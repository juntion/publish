<?php


namespace App\ProjectManage\Repositories;


use App\Enums\ProjectManage\AppealStatus;
use App\Enums\ProjectManage\DemandConfirm;
use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DesignPartStatus;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\Task\FrontendSubTaskStatus;
use App\Enums\ProjectManage\Task\FrontendTaskStatus;
use App\Enums\ProjectManage\Task\MobileSubTaskStatus;
use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\Enums\ProjectManage\TeamType;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Enums\ProjectManage\TestTaskStatus;
use App\Events\PM\Demand\DemandToTest;
use App\Events\PM\Task\TaskSetHandler;
use App\Exceptions\Demand\DemandPermissionException;
use App\Exceptions\Demand\InvaildParameterException;
use App\Exceptions\System\InvalidParameterException;
use App\Http\Resources\ActivityLogResource;
use App\Http\Resources\DemandDesignResource;
use App\Http\Resources\DemandDevResource;
use App\Http\Resources\DemandFrontendResource;
use App\Http\Resources\DemandListResource;
use App\Http\Resources\DemandMobileResource;
use App\Http\Resources\DemandTestResource;
use App\Http\Resources\MediaResource;
use App\Models\User;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Demand;
use App\ProjectManage\Models\DesignTask;
use App\ProjectManage\Models\DevTask;
use App\ProjectManage\Models\FrontendTask;
use App\ProjectManage\Models\MobileTask;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Project;
use App\ProjectManage\Models\TestTask;
use App\Repositories\BaseRepository;
use App\Support\Upload;
use App\Traits\RemindTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\ActivityLogger;

class DemandRepository extends BaseRepository
{
    use RemindTrait;
    protected $model;
    protected $allowedSearches = ['priority','promulgator_id', 'status','principal_user_id','products.id', 'source_project_id', 'project.principal_user_id', 'id'];
    protected $allowedIncludes = ['media','products','demand_links'];
    protected $allowedScopeSearches = ['created_at', 'keyword', 'related_project'];
    protected $allowedAppends = ['product_category'];
    protected $shouldAppends = [
        'product_category',
        'policies',
    ];

    protected $allowedMust = ['appeals.number','number', 'name', 'priority', 'source_project_id', 'source_project_name',  'promulgator_id', 'principal_user_id',  'status', 'created_at', 'finish_time', 'content', 'attentionAble.user_id'];

    protected $allowedScopeMust = ['productLine', 'productName', 'productModule', 'productCategory', 'designManager', 'devManager', 'testManager', 'frontEndManager', 'mobileManager',];

    protected $allowedSorts = ['created_at', 'priority'];
    protected $user;

    protected $showRemindData = [
        DemandStatus::STATUS_TO_ACCEPT,
        DemandStatus::STATUS_REJECTED,
        DemandStatus::STATUS_TO_PUSH,
        DemandStatus::STATUS_TO_ASSIGN,
        DemandStatus::STATUS_NO_BEGIN,
        DemandStatus::STATUS_IN_PROGRESS,
        DemandStatus::STATUS_SUBMIT,
        DemandStatus::STATUS_TO_TEST,
        DemandStatus::STATUS_IN_TEST,
        DemandStatus::STATUS_PAUSED,
    ];

    protected $del_links = [];
    protected $add_links = [];
    public function __construct(Demand $demand)
    {
        $this->model = $demand;
        $this->user = Auth::user();
    }
    /**
     * 确认需求
     * @return bool
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function confirm()
    {
        $id = \request('id');
        $demand = Demand::query()->where("confirmed", 0)->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求已确认');
        }
        if (!$this->user->can('confirmDemand', $demand)){
            throw new DemandPermissionException('权限错误！您无权确认需求');
        }
        $demand->confirmed = 1;
        $demand->save();
        return true;
    }


    /**
     * 取消确认
     * @return bool
     * @throws DemandPermissionException
     * @throws InvaildParameterException
     */
    public function cancelConfirm()
    {
        $id = \request('id');
        $demand = Demand::query()
            ->where('confirmed', DemandConfirm::HAS_CONFIRM)
            ->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求无法取消确认');
        }
        if (!$this->user->can('cancelConfirmDemand', $demand)){
            throw new DemandPermissionException('权限错误！您无权确认需求');
        }
        $demand->confirmed = 0;
        $demand->save();
        return true;
    }
    /**
     * 推送需求
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function pushDemand(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->where('status', DemandStatus::STATUS_TO_PUSH)->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求不能推送！');
        }
        if (!$this->user->can('pushDemand', $demand)){
            throw new DemandPermissionException("权限错误！您无权推送该需求");
        }
        DB::beginTransaction();
        try{
            $demand->update([
                'status' => DemandStatus::STATUS_TO_ASSIGN
            ]);
            $this->createMainTask($demand);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error('推送失败:' . $exception);
            throw new InvaildParameterException('推送失败！请稍后再试');
        }
        DB::commit();
        return true;
    }

    /**
     * 批量推送
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function batchPushDemand(Request $request)
    {
        $demands = Demand::query()
            ->whereIn('id', $request->input('demand_ids'))
            ->where('status', DemandStatus::STATUS_TO_PUSH)
            ->get();
        if ($demands->isEmpty()){
            throw new DemandPermissionException("均已推送，无需重复推送!");
        }
        DB::beginTransaction();
        try{
            $demands->map(function ($item){ //批量赋值不会触发 updated事件
                if(!$this->user->can('pushDemand', $item)){
                    throw new DemandPermissionException('权限错误！您无权推送 《' . $item->name . '》');
                }
                $item->update([
                    'status' => DemandStatus::STATUS_TO_ASSIGN
                ]);
                $this->createMainTask($item);
            });
        }catch (\Exception $exception){
            DB::rollBack();
            if ($exception instanceof DemandPermissionException) {
                throw $exception;
            }
            \Log::error("批量推送失败：" . $exception);
            throw new InvaildParameterException('批量推送失败！请稍后再试');
        }
        DB::commit();
        return true;
    }

    /**
     * 批量确认
     * @param Request $request
     * @return bool
     * @throws DemandPermissionException
     * @throws InvaildParameterException
     */
    public function batchConfirm(Request $request)
    {
        $demands = Demand::query()
            ->whereIn('id', $request->input('demand_ids'))
            ->where("confirmed", DemandConfirm::NOT_CONFIRM)
            ->get();
        if ($demands->isEmpty()){
            throw new DemandPermissionException("均已确认，无需重复确认!");
        }
        DB::beginTransaction();
        try {
            $demands->map(function ($item){
                if(!$this->user->can('confirmDemand', $item)){
                    throw new DemandPermissionException('权限错误！您无权确认 《' . $item->name . '》');
                }
                $item->update([
                    'confirmed' => DemandConfirm::HAS_CONFIRM
                ]);
            });
        }catch (\Exception $exception){
            DB::rollBack();
            if ($exception instanceof DemandPermissionException) {
                throw $exception;
            }
            \Log::error("批量确认失败：" . $exception);
            throw new InvaildParameterException('批量确认失败！请稍后再试');
        }
        DB::commit();
        return true;
    }

    /**
     * 暂停需求
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function pauseDemand(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->whereNotIn('status',[
            DemandStatus::STATUS_TO_ACCEPT,
            DemandStatus::STATUS_REJECTED,
            DemandStatus::STATUS_COMPLETED,
            DemandStatus::STATUS_PAUSED,
            DemandStatus::STATUS_REVOCATION
        ])->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求不能暂停！！');
        }
        if (!$this->user->can('pauseDemand', $demand)){
            throw new DemandPermissionException('权限错误！您无权暂停该需求');
        }
        DB::beginTransaction();
        try{
            $demand->update([
                'status' => DemandStatus::STATUS_PAUSED
            ]);
            $this->updateTaskStatus($demand, 'STATUS_PAUSED');
        }catch (\Exception $exception){
            \Log::error("暂停需求失败：" . $exception);
            DB::rollBack();
            throw new InvaildParameterException("暂停需求失败！请稍后再试");
        }
        DB::commit();
        return true;
    }

    /**
     * 撤销需求
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function revocationDemand(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->whereNotIn('status',[
            DemandStatus::STATUS_COMPLETED,
            DemandStatus::STATUS_REVOCATION
        ])->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求不能撤销！');
        }

        if (!$this->user->can('revocationDemand', $demand)){
            throw new DemandPermissionException('权限错误！您无权撤销该需求');
        }
        DB::beginTransaction();
        try{
            $demand->update([
                'status' => DemandStatus::STATUS_REVOCATION
            ]);
            $this->updateTaskStatus($demand, 'STATUS_REVOCATION');
            $this->updateAppeals($demand);
        }catch (\Exception $exception){
            \Log::error("撤销需求失败：" . $exception);
            DB::rollBack();
            throw new InvaildParameterException("暂停需求失败！请稍后再试");
        }
        DB::commit();
        return true;
    }

    /**
     * 更新关联诉求
     * @param Demand $demand
     */
    protected function updateAppeals(Demand $demand)
    {
        $appeals = $demand->appeals()->get();
        if ($appeals->isEmpty()) return;
        $appeals->each(function (Appeal $appeal) {
            $appeal->update([
                'status' => AppealStatus::STATUS_TO_ACCEPT,
                'demand_id' => 0,
            ]);
        });
    }

    /**
     * 继续需求
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function continueDemand(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->where('status', DemandStatus::STATUS_PAUSED)->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求不能继续开启！');
        }
        if (!$this->user->can('continueDemand', $demand)){
            throw new DemandPermissionException('权限错误！您无权继续该需求');
        }
        DB::beginTransaction();
        try{
            $status_history = $demand->statusLogs()->where('new_status', 10)->orderBy('id',"DESC")->first();
            $demand->update([
                'status' => $status_history->old_status
            ]);
            $this->continueTask($demand);
        }catch (\Exception $exception){
            \Log::error("继续任务失败：" . $exception);
            DB::rollBack();
            throw new InvaildParameterException("继续任务失败！");
        }
        DB::commit();
        return true;
    }

    /**
     * 需求详情
     * @param Request $request
     * @return mixed
     * @throws InvaildParameterException
     */
    public function demandDetails(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->where('id', $id)->with(['products', 'media', 'demandLinks', 'attentionAble', 'appeals.products',
            'versions', 'designSubtasks.version', 'devSubtasks.version', 'frontendSubtasks.version', 'mobileSubTasks.version'])->first();
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误，找不到相关信息');
        }
        $docs = $this->getTaskDocs($demand);
        $demand->deleteIsUpdated();
        $design = $demand->designTasks()->where('status', '>', DesignTaskStatus::STATUS_TO_AUDIT)->first();
        $changes = ActivityLogResource::collection($demand->changes()->orderBy('created_at', 'desc')->get());
        $media = MediaResource::collection($demand->media);
        // $source_appeals = DemandAppealResource::collection($demand->appeals);
        $design_role = $demand->designPart()->whereHas('task', function ($q){
            $q->where($q->qualifyColumn('status'), '>', DesignTaskStatus::STATUS_TO_AUDIT);
        })->select("type")->get()->groupBy('type')->keys();
        $demand->append(['product_category', 'policies', 'is_attention']);
        $demand->labels = $demand->getLabels();
        // 需求关联诉求及诉求产品
        $demandAppeals = $demand->appeals->map(function (Appeal $appeal) {
            $appeal->append('product_category');
            return [
                'id' => $appeal->id,
                'number' => $appeal->number,
                'product_category' => $appeal->product_category,
            ];
        });
        $taskVersions = collect();
        $taskVersions = $taskVersions->merge($demand->designSubtasks->map($this->mapSubTasks()))
            ->merge($demand->devSubtasks->map($this->mapSubTasks()))
            ->merge($demand->frontendSubtasks->map($this->mapSubTasks()))
            ->merge($demand->mobileSubTasks->map($this->mapSubTasks()));
        $demand->task_versions = $taskVersions->filter();
        $demand = $demand->toArray();
        if ($demand['priority'] == 0){
            $demand['priority'] = "";
        }
        if ($demand['source_project_id'] == 0){
            $demand['source_project_id'] = "";
        }
        $demand['user_attention'] = $demand['attention_able'];
        $demand['operation_logs'] = $changes;
        $demand['media'] = $media;
        $demand['appeals'] = $demandAppeals;
        $demand['design_type'] = $design && $design->status > 1 ? $design->design_type : null;
        $demand['design_roles'] = $design_role->isNotEmpty() ? $design_role : null;
        $demand['expected_versions'] = $demand['versions'];
        unset($demand['versions']);
        unset($demand['design_subtasks']);
        unset($demand['dev_subtasks']);
        unset($demand['frontend_subtasks']);
        unset($demand['mobile_sub_tasks']);
        unset($demand['attention_able']);
        unset($demand['changes']);
        unset($demand['dev_tasks']);
        return compact('demand','docs');
    }

    /**
     * @return \Closure
     */
    protected function mapSubTasks()
    {
        return function ($subTask) {
            $version = [];
            // 发布类型：0：跟随版本发布；1：hotfix上线；2：无需发布
            if ($subTask->release_type === 0 && !empty($subTask->version)) {
                $version = $subTask->version->toArray();
                $version['release_type'] = $subTask->release_type;
            } elseif (in_array($subTask->release_type, [1, 2])) {
                $version['release_type'] = $subTask->release_type;
            }
            return $version;
        };
    }

    /**
     * 审核需求
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function verify(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->whereIn('status', [
            DemandStatus::STATUS_TO_ACCEPT,
            DemandStatus::STATUS_REJECTED
        ])->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求无法被审核！');
        }
        if (!$this->user->can('verifyDemand', $demand)){
            throw new DemandPermissionException('权限错误！您无权审核该需求');
        }
        $status = $request->input('result') == 0 ? DemandStatus::STATUS_REJECTED : DemandStatus::STATUS_TO_PUSH;
        if ($status == DemandStatus::STATUS_TO_PUSH && $demand->source_project_id == 0) {
            $status = DemandStatus::STATUS_TO_ASSIGN;
        }
        $appealStatus = $request->input('result') == 0 ? AppealStatus::STATUS_FOLLOWING : AppealStatus::STATUS_HAS_PROJECT;
        DB::beginTransaction();
        try{
            $demand->update([
                'status' => $status,
                'verify_time' => Carbon::now(),
                'verify_user_id' => $this->user->id,
                'verify_user_name' => $this->user->name,
            ]);

            $demand->appeals()->get()->map(function ($item)use ($appealStatus){
                $item->update([
                    'status' => $appealStatus
                ]);
            });
            // 没有关联项目的 直接写任务相关
            if ($status == DemandStatus::STATUS_TO_ASSIGN) {
                $this->createMainTask($demand);
            }
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error("审核失败:" . $exception);
            throw new InvaildParameterException('审核失败！请稍后再试');
        }
        DB::commit();
        return true;
    }

    /**
     * 状态的日志记录
     * @param Request $request
     * @return array
     * @throws InvaildParameterException
     */
    public function getStatusLogs(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求！');
        }
        $data = [];
        $demand->statusLogs()->orderBy('id','DESC')->get()->map(function ($item)use(&$data){
            $info['user_name'] = $item->user_name;
            $info['status'] = $item->new_status_desc;
            $info['comment'] = $item->comment;
            $info['created_at'] = date("Y-m-d H:i:s", strtotime($item->created_at));
            $data['status_logs'][] = $info;
        });
        return $data;
    }

    /**'
     * 开启测试
     * @param Demand $demand
     * @return bool
     */
    public function beginTest(Demand $demand)
    {
        $testLink = $demand->demandLinks()->where('type', DemandLinksType::TYPE_TEST)->get();
        $testLinkHandler = null;
        if ($testLink->isEmpty()){
            // 无测试环节的需求直接变为 测试中
            $status = DemandStatus::STATUS_IN_TEST;
        } else {
            $status = DemandStatus::STATUS_TO_TEST;
            // 产品自测，测试环节负责人处理
            if ($testLink->first()->group == 1) {
                $testLinkHandler = User::query()->find($testLink->first()->principal_user_id);
            }
        }
        $demand->update([
            'status' => $status
        ]);
        // 2020-06-08 设计走查数据触发规则调整：当需求研发环节，仅有设计环节时，需求操作“更新测试”功能之后，不触发设计走查
        $devLink = $demand->demandLinks()->where('type', DemandLinksType::TYPE_DEVELOP)->get();
        if ($devLink->isNotEmpty() || $testLink->isNotEmpty()) {
            // 关联的设计总任务更新
            $demand->designTasks->map(function ($item) {
                $item->update([
                    'review' => DesignTaskStatus::REVIEW_NO_BEGIN
                ]);
            });
        }
        $demand->testTasks->map(function ($item) use ($testLinkHandler, $demand) {
            if (empty($item->principal_user_id) && $testLinkHandler) {
                $testTaskData['principal_user_id'] = $testLinkHandler->id;
                $testTaskData['principal_user_name'] = $testLinkHandler->name;
            }
            // todo 当测试任务未审核，需求先开启测试，测试任务会被改成"待测试"，从而跳过审核过程
            $testTaskData['status'] = TestTaskStatus::STATUS_NO_BEGIN;
            $item->update($testTaskData);
            // 需求发布测试邮件通知
            event(new DemandToTest($demand));

            $subTasks = $item->subTasks()->get();
            // 测试子任务为空，产品自测时需创建子任务
            if ($subTasks->isEmpty() && $testLinkHandler) {
                $subTaskData = [
                    'is_main' => 1,
                    'handler_id' => $testLinkHandler->id,
                    'handler_name' => $testLinkHandler->name,
                    'status' => TestSubTaskStatus::STATUS_NO_BEGIN,
                    'expiration_date' => $demand->expiration_date ?? now()->toDateString(),
                ];
                $subTask = $item->subTasks()->create($subTaskData);
                event(new TaskSetHandler($subTask, $testLinkHandler));
            }
            $subTasks->each(function ($subTask) use ($testLinkHandler) {
                $subTaskData = ['status' => TestSubTaskStatus::STATUS_NO_BEGIN];
                if (empty($subTask->handler_id) && $testLinkHandler) {
                    $subTaskData['handler_id'] = $testLinkHandler->id;
                    $subTaskData['handler_name'] = $testLinkHandler->name;
                }
                $subTask->update($subTaskData);
                // 更改处理人邮件通知
                if ($subTask->wasChanged('handler_id')) {
                    event(new TaskSetHandler($subTask, $testLinkHandler));
                }
            });
        });
        //
        return true;
    }

    /**
     * 完成需求
     * @param Demand $demand
     * @return bool
     * @throws InvaildParameterException
     */
    public function complete(Demand $demand)
    {
        if ($demand->testTasks()->exists() && $demand->testTasks()->whereNotIn('status',
                [TestTaskStatus::STATUS_COMPLETED, TestTaskStatus::STATUS_REVOCATION])->exists()) {
            throw new InvaildParameterException('存在测试任务未完成，请先完成');
        }
        DB::beginTransaction();
        try{
            $demand->update([
                'status'      => DemandStatus::STATUS_COMPLETED,
                'finish_time' => Carbon::now()
            ]);
            $demand->appeals()->get()->map(function ($item){
                $item->update([
                    'status' =>  AppealStatus::STATUS_COMPLETED,
                    'finish_time' => Carbon::now()
                ]);
            });
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error('验收失败' . $exception);
            throw new InvaildParameterException('验收操作失败！');
        }
        DB::commit();
        return true;
    }

    /**
     * 设置优先级
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     */
    public function priority(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求！');
        }
        if (!$this->user->can('priority', $demand)){
            throw new DemandPermissionException('权限错误！');
        }
        $demand->update([
            'priority' => $request->input('priority')
        ]);
        return true;
    }

    /**
     * @param Request $request
     * @return array
     * @throws InvaildParameterException
     */
    public function allTasks(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求！');
        }
        $design_subtasks = $dev_subtasks = $test_subtasks = $frontend_subtasks = $mobile_subtasks = [];
        $design_subtasks_arr = DemandDesignResource::collection($demand->designTasks()->get())->all();
        foreach ($design_subtasks_arr as $val){
            $design_subtasks = array_merge($design_subtasks, collect($val)->all());
        }
        $dev_subtasks_arr = DemandDevResource::collection($demand->devTasks()->get())->all();
        foreach ($dev_subtasks_arr as $val){
            $dev_subtasks = array_merge($dev_subtasks, collect($val)->all());
        }
        $test_subtasks_arr = DemandTestResource::collection($demand->testTasks()->get())->all();
        foreach ($test_subtasks_arr as $val){
            $test_subtasks = array_merge($test_subtasks, collect($val)->all());
        }
        $frontend_subtasks_arr = DemandFrontendResource::collection($demand->frontendTasks()->get())->all();
        foreach ($frontend_subtasks_arr as $val) {
            $frontend_subtasks = array_merge($frontend_subtasks, collect($val)->all());
        }
        $mobile_subtasks_arr = DemandMobileResource::collection($demand->mobileTasks()->get())->all();
        foreach ($mobile_subtasks_arr as $val) {
            $mobile_subtasks = array_merge($mobile_subtasks, collect($val)->all());
        }
        return array_merge($design_subtasks, $dev_subtasks, $test_subtasks, $frontend_subtasks, $mobile_subtasks);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDemandList(Request $request)
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }
        $limit = $request->input('limit') ?? 20;
        $data = $this->getModelsList($limit);
        $data->load(['media', 'products', 'demandLinks', 'project', 'appeals.labels', 'versions.product', 'attentionAble', 'testSubtasks',
            'designTasks', 'designPart.subTasks', 'devTasks.subTasks', 'testTasks.subTasks', 'frontendTasks.subTasks', 'mobileTasks.subTasks',
            // 子任务版本
            'designSubtasks.version.product', 'devSubtasks.version.product', 'frontendSubtasks.version.product', 'mobileSubTasks.version.product',
        ]);
        $this->handleAppends($data);
        $result = $data->toArray();
        $result['data'] = DemandListResource::collection($data);
        $result['remind'] = $this->getRemind();
        unset($data);
        return $result;
    }

    /**
     * 导出数据
     * @param Request $request
     * @return \App\Support\QueryBuilder\QueryBuilder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function exportData()
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }
        $data = $this->getModels();
        $data->load(['promulgatorUser.departments', 'project', 'demandLinks', 'appeals', 'products', 'designTasks', 'designPart.subTasks', 'devTasks.subTasks', 'devSubtasks', 'testTasks.subTasks']);
        return $data;
    }

    /**
     * 新增需求 | 诉求立项
     * @param Request $request
     * @throws InvaildParameterException
     */
    public function createDemands(Request $request)
    {
        $insertData = $request->only(['product_id', 'priority', 'expiration_date', 'source_project_id', 'source_project_name', 'source_bug_id', 'name', 'content', 'share_address']);
        $productManager = $this->getPrincipalInfoByProductId($request->input('product_id'), TeamType::TYPE_PRODUCT);
        if (empty($productManager)) {
            throw new InvaildParameterException('产品负责人不能为空，请先设置产品负责人');
        }
        // 是否来自诉求立项
        if ($isFromAppeals = $request->has('appeal_ids')) {
            $appeals = Appeal::query()->whereIn('id', $request->appeal_ids)->with('products')->get();
            $appeal = $appeals->first();
            // 诉求的产品
            $appealProducts = [];
            $appeals->each(function ($item) use (&$appealProducts) {
                $appealProduct = $item->products->where('type', ProductStatus::TypeProduct)->first();
                $appealProducts[] = $appealProduct->id;
            });
            // 如果需求选择的产品和诉求有相同，取诉求的负责人
            if (in_array($request->input('product_id'), $appealProducts)) {
                $productManager->user_id = $appeal->principal_user_id;
                $productManager->user_name = $appeal->principal_user_name;
            }
        }
        $isProductManager = !is_null($productManager) && $this->user->id == $productManager->user_id;
        $pushNow = false;
        $status = DemandStatus::STATUS_TO_ACCEPT;
        if($isProductManager && !$request->has('source_project_id')){
            $pushNow = true;
            $status = DemandStatus::STATUS_TO_ASSIGN;
            // 只有测试环节
            $links = $request->input('demand_links');
            if(isset($links['test']) && !isset($links['dev']) && !isset($links['design'])){ // 未关联项目 状态为待测试
                $status = DemandStatus::STATUS_TO_TEST;
            }
        }
        if($isProductManager && $request->has('source_project_id')){
            $status = DemandStatus::STATUS_TO_PUSH;
        }
        $insertData['promulgator_id'] = $this->user->id;
        $insertData['promulgator_name'] = $this->user->name;
        $insertData['confirmed'] = 0;
        $insertData['status'] = $status;
        $insertData['principal_user_id'] = $productManager->user_id;
        $insertData['principal_user_name'] = $productManager->user_name;
        if (!isset($insertData['priority'])){
            $insertData['priority'] = 0;
        }
        DB::beginTransaction();
        try{
            $demand = Demand::query()->create($insertData);
            $this->setRelateProduct($demand, $request);
            $this->markLinks($demand, $request, true);
            if($request->input('attention_user_ids')){
                $this->addAttentionUser($demand, $request->input('attention_user_ids'));
            }
            $this->uploadMedia($demand, $request);
            if ($pushNow) {
                $this->createMainTask($demand);
            }
            // 关联诉求
            if ($isFromAppeals) {
                $appeals->each(function (Appeal $appeal) use ($demand, $isProductManager) {
                    $appeal->demand_id = $demand->id;
                    $appeal->status = $isProductManager ? AppealStatus::STATUS_HAS_PROJECT : AppealStatus::STATUS_PENDING_REVIEW;
                    $appeal->save();
                });
            }
            // 预计纳入版本号
            if ($versionIds = $request->input('release_version_ids')) {
                $demand->versions()->attach($versionIds);
            }
        }catch (\Exception $exception){
            DB::rollBack();
            if ($exception instanceof InvaildParameterException){
                throw new InvaildParameterException($exception->getMessage());
            }
            \Log::error('新建需求失败：' . $exception);
            throw new InvaildParameterException('新建需求失败！');
        }
        DB::commit();
    }

    /**
     * 设置关联的products
     * @param Demand $demand
     * @param Request $request
     */
    protected function setRelateProduct(Demand $demand, Request $request)
    {
        $products = [];
        if($request->has('product_id')){
            $pid =  $request->input('product_id');
            $product = Product::query()->find($pid);
            $products[$product->id] = [
                'product_type' =>$product->type
            ];
            $products = getAllParentsOfProduct($product, $products); // 向上找了产品及产品线
        }
        $demand->products()->sync($products);
    }

    /**
     * 记录或更新环节信息
     * @param Demand $demand
     * @param Request $request
     * @throws InvaildParameterException
     */
    protected function markLinks(Demand $demand, Request $request, $updatePrincipal = false)
    {
        $links = $request->input('demand_links');
        $designType = TeamType::TYPE_DESIGN;
        $devType = TeamType::TYPE_DEVELOP;
        $testType = TeamType::TYPE_TEST;
        $frontendType = TeamType::TYPE_FRONTEND;
        $mobileType = TeamType::TYPE_MOBILE;
        $hasLinks = $demand->demandLinks()
            ->where('demand_id', $demand->id)
            ->get();
        if (isset($links['design'])){
            $project_design = $this->getPrincipalInfoByProductId($request->input('product_id'), $designType);
            if (is_null($project_design)){
                throw new InvaildParameterException('所选产品无设计负责人');
            }
            $hasDesignLinks = $hasLinks->where('type', DemandLinksType::TYPE_DESIGN)->isNotEmpty();
            if(!$updatePrincipal && $hasDesignLinks) {
                $updatePrincipalData = [
                    'comment'             => $links['design']['comment'] ?? ''
                ];
            } else {
                $updatePrincipalData = [
                    'principal_user_id'   => $project_design->user_id,
                    'principal_user_name' => $project_design->user_name,
                    'comment'             => $links['design']['comment'] ?? ''
                ];
            }
            $demand->demandLinks()->updateOrCreate(
                [
                    'demand_id' => $demand->id,
                    'type'      => DemandLinksType::TYPE_DESIGN
                ],$updatePrincipalData
            );
        } else {
            // 不存在时删除原来的
            $demand->demandLinks()->where('type' ,DemandLinksType::TYPE_DESIGN )->get()->map(function ($item){
                $item->delete(); // map 避免批量删除无法触发observer 的deleted 监听
            });
        }

        if (isset($links['dev'])){
            $project_dev = $this->getPrincipalInfoByProductId($request->input('product_id'), $devType);
            if (is_null($project_dev)){
                throw new InvaildParameterException('所选产品无开发负责人');
            }
            $hasDevLinks = $hasLinks->where('type', DemandLinksType::TYPE_DEVELOP)->isNotEmpty();
            if (!$updatePrincipal && $hasDevLinks){
                $updatePrincipalData = [
                    'comment'             => $links['dev']['comment'] ?? '',
                ];
            } else {
                $updatePrincipalData = [
                    'principal_user_id'   => $project_dev->user_id,
                    'principal_user_name' => $project_dev->user_name,
                    'comment'             => $links['dev']['comment'] ?? '',
                ];
            }
            $demand->demandLinks()->updateOrCreate(
                [
                    'demand_id' => $demand->id,
                    'type'      => DemandLinksType::TYPE_DEVELOP
                ],$updatePrincipalData
            );
        } else {
            // 不存在时删除原来的
            $demand->demandLinks()->where('type' ,DemandLinksType::TYPE_DEVELOP )->get()->map(function ($item){
                $item->delete(); // map 避免批量删除无法触发observer 的deleted 监听
            });
        }

        if (isset($links['test'])){
            if ($links['test']['group'] == 0) {
                $project_test = $this->getPrincipalInfoByProductId($request->input('product_id'), $testType);
                if (is_null($project_test)){
                    throw new InvaildParameterException('所选产品无测试负责人');
                }
                $updateData = [];
                $hasTestLinks = $hasLinks->where('type', DemandLinksType::TYPE_TEST)->where('group',0)->isNotEmpty();
                if ($updatePrincipal || !$hasTestLinks) {
                    $updateData = [
                        'principal_user_id'   => $project_test->user_id,
                        'principal_user_name' => $project_test->user_name,
                        'group'               => 0,
                    ];
                }
            } else {
                // 产品自测 测试负责人是发布人
                $updateData = [
                    'principal_user_id'   => $demand->promulgator_id,
                    'principal_user_name' => $demand->promulgator_name,
                    'group'               => 1
                ];

            }
            $updateData['comment'] = $links['test']['comment'] ?? "";
            $demand->demandLinks()->updateOrCreate(
                [
                    'demand_id' => $demand->id,
                    'type'      => DemandLinksType::TYPE_TEST
                ],
                $updateData
            );
        } else {
            // 不存在时删除原来的
            $demand->demandLinks()->where('type' ,DemandLinksType::TYPE_TEST )->get()->map(function ($item){
                $item->delete(); // map 避免批量删除无法触发observer 的deleted 监听
            });
        }

        // 前端环节
        if (isset($links['frontend'])) {
            $projectFront = $this->getPrincipalInfoByProductId($request->input('product_id'), $frontendType);
            if (is_null($projectFront)) {
                throw new InvaildParameterException('所选产品无前端负责人');
            }
            $hasFrontLinks = $hasLinks->where('type', DemandLinksType::TYPE_FRONTEND)->isNotEmpty();
            if (!$updatePrincipal && $hasFrontLinks) {
                $updatePrincipalData = [
                    'comment' => $links['frontend']['comment'] ?? '',
                ];
            } else {
                $updatePrincipalData = [
                    'principal_user_id' => $projectFront->user_id,
                    'principal_user_name' => $projectFront->user_name,
                    'comment' => $links['frontend']['comment'] ?? '',
                ];
            }
            $demand->demandLinks()->updateOrCreate(
                [
                    'demand_id' => $demand->id,
                    'type' => DemandLinksType::TYPE_FRONTEND,
                ], $updatePrincipalData
            );
        } else {
            // 不存在时删除原来的
            $demand->demandLinks()->where('type', DemandLinksType::TYPE_FRONTEND)->get()->map(function ($item) {
                $item->delete(); // map 避免批量删除无法触发observer 的deleted 监听
            });
        }

        // 移动端环节
        if (isset($links['mobile'])) {
            $projectMobile = $this->getPrincipalInfoByProductId($request->input('product_id'), $mobileType);
            if (is_null($projectMobile)) {
                throw new InvaildParameterException('所选产品无移动端负责人');
            }
            $hasMobileLinks = $hasLinks->where('type', DemandLinksType::TYPE_MOBILE)->isNotEmpty();
            if (!$updatePrincipal && $hasMobileLinks) {
                $updatePrincipalData = [
                    'comment' => $links['mobile']['comment'] ?? '',
                ];
            } else {
                $updatePrincipalData = [
                    'principal_user_id' => $projectMobile->user_id,
                    'principal_user_name' => $projectMobile->user_name,
                    'comment' => $links['mobile']['comment'] ?? '',
                ];
            }
            $demand->demandLinks()->updateOrCreate(
                [
                    'demand_id' => $demand->id,
                    'type' => DemandLinksType::TYPE_MOBILE,
                ], $updatePrincipalData
            );
        } else {
            // 不存在时删除原来的
            $demand->demandLinks()->where('type', DemandLinksType::TYPE_MOBILE)->get()->map(function ($item) {
                $item->delete(); // map 避免批量删除无法触发observer 的deleted 监听
            });
        }
    }

    /**
     * 设置关注的人
     * @param Demand $demand
     * @param $uids
     * @throws InvaildParameterException
     */
    protected function addAttentionUser(Demand $demand, $uids)
    {
        foreach ($uids as $v){
            $user = User::query()->find($v);
            $userDept = $user->department->first();
            if (!$userDept){
                throw new InvaildParameterException("所选用户{$user->name} 没有绑定部门信息！");
            }
            $demand->attentionAble()->create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'dept_id' => $userDept->id,
                'dept_name' => $userDept->name,
            ]);
        }
    }

    /**
     * 项目关联Media
     * @param Project $project
     * @param Request $request
     */
    protected function uploadMedia(Demand $demand, Request $request){
        $update = false;
        $old = [];
        $new = [];

        $old = $demand->media()->get()->pluck('name')->toArray();
        if (!$request->has('old_media') && !empty($old)){
            $update = true;
            $demand->media()->delete();
        } else if($request->has('old_media')) {
            $del_media = $demand->media()->whereNotIn('id', $request->input('old_media'));
            $num = $del_media->count();
            if ($num > 0) {
                $update = true;
                $old = $demand->media()->get()->pluck('name')->toArray();
                $del_media->delete();
            }
        }

        if ($request->file('new_media')){
            $update = true;
            if (empty($old)) {
                $old = $demand->media()->get()->pluck('name')->toArray();
            }
            collect($request->file('new_media'))->map(function ($media)use ($demand){
                $path = Upload::addFile($media)->save();
                $demand->moveTmpMedia($demand->docsMedia, $path, true);
            });
        }
        if ($update) {
            $new = $demand->media()->get()->pluck('name')->toArray();
            $mediaChanges = [
                'name' => '附件更新',
                'old'  => implode(',', $old),
                'new'  => implode(',', $new)
            ];
            $key = 'demand_id_' . $demand->id . '_user_id_' .$this->user->id;
            $demand->updateCacheOfUpdated($key, $mediaChanges);
        }
        if ($request->file('media')){
            collect($request->file('media'))->map(function ($media)use ($demand){
                $path = Upload::addFile($media)->save();
                $demand->moveTmpMedia($demand->docsMedia, $path, true);
            });
        }
    }

    /**
     * 更新需求
     * @param Request $request
     * @throws InvaildParameterException
     * @throws DemandPermissionException
     */
    public function updateDemand(Request $request)
    {
        $updateData= $request->only(['product_id', 'priority' , 'expiration_date','source_project_id', 'source_project_name','name','content','share_address']);
        $demand = Demand::query()->whereNotIn('status', [
            DemandStatus::STATUS_COMPLETED,
            DemandStatus::STATUS_REVOCATION
        ])->find($request->id);
        if (is_null($demand)) {
            throw new InvaildParameterException('参数错误！未找到指定项目或项目无法被更新');
        }
        if ($this->user->cant('updateDemand', $demand)){
            throw new DemandPermissionException('权限错误，您无权更新该需求');
        }
        if (!isset($updateData['source_project_id'])) {
            $updateData['source_project_id'] = 0;
            $updateData['source_project_name'] = '';
        }
        if ($demand->source_project_id != $updateData['source_project_id'] && !in_array($demand->status, [
                DemandStatus::STATUS_TO_PUSH,
                DemandStatus::STATUS_TO_ACCEPT,
                DemandStatus::STATUS_REJECTED,
                DemandStatus::STATUS_TO_ASSIGN
            ])){
            throw new DemandPermissionException("当前状态下无法修改项目来源");
        }

        $updateSourceProjectId = false;
        if ($demand->source_project_id != $updateData['source_project_id']) {
            $updateSourceProjectId = true;
        }

        $pid = $request->input('product_id');
        $old_pid = $demand->products()->where('type', ProductStatus::TypeProduct)->first()->id;
        $updateProducts = false;
        if ($pid != $old_pid){ // 产品信息被修改
            $updateProducts = true;
        }
        if ($updateProducts && !in_array($demand->status, [
                DemandStatus::STATUS_TO_PUSH,
                DemandStatus::STATUS_TO_ACCEPT,
                DemandStatus::STATUS_REJECTED,
                DemandStatus::STATUS_TO_ASSIGN,
            ])){
            throw new DemandPermissionException("当前状态下无法修改产品相关信息");
        }

        // 验证是否可以编辑修改研发团队
        $hasUpdateDemandLink = $this->hasUpdateDemandLink($demand, $request);
        if ($hasUpdateDemandLink && in_array($demand->status, [
                DemandStatus::STATUS_TO_TEST,
                DemandStatus::STATUS_IN_TEST,
                DemandStatus::STATUS_PAUSED,
                DemandStatus::STATUS_SUBMIT
            ])){
            throw new DemandPermissionException("当前状态下无法修改需求的开发团队信息");
        }
        $updateAppealStatus = false;
        //编辑 操作，当状态变为 审核驳回 ，提交后需求变为 待审核，关联诉求变为立项待审核
        if ($demand->status == DemandStatus::STATUS_REJECTED){
            $updateData['status'] = DemandStatus::STATUS_TO_ACCEPT;
            $updateAppealStatus = true;
            $appealStatus = AppealStatus::STATUS_PENDING_REVIEW;
        }
        $key = 'demand_id_' . $demand->id . '_user_id_' .$this->user->id;
        $demand->forgetUpdatedCache($key);
        $pushNow = false;
        if ($updateProducts) {
            // 更新产品 重新走一下发布时的逻辑验证是否直接推送，是否直接审核完成
            $productManager = $this->getPrincipalInfoByProductId($request->input('product_id'), TeamType::TYPE_PRODUCT);
            if (empty($productManager)) {
                throw new InvaildParameterException('产品负责人不能为空，请先设置产品负责人');
            }

            // 是否来自诉求立项
            if ($demand->appeals) {
                $appeals =$demand->appeals()->with('products')->get();
                $appeal = $appeals->first();
                // 诉求的产品
                $appealProducts = [];
                $appeals->each(function ($item) use (&$appealProducts) {
                    $appealProduct = $item->products->where('type', ProductStatus::TypeProduct)->first();
                    $appealProducts[] = $appealProduct->id;
                });
                // 如果需求选择的产品和诉求有相同，取诉求的负责人
                if (in_array($request->input('product_id'), $appealProducts)) {
                    $productManager->user_id = $appeal->principal_user_id;
                    $productManager->user_name = $appeal->principal_user_name;
                }
            }

            $isProductManager = !is_null($productManager) && $this->user->id == $productManager->user_id;
            $updateData['status'] = DemandStatus::STATUS_TO_ACCEPT;
            if ($isProductManager && !$request->has('source_project_id')) {
                $pushNow = true;
                $updateData['status'] = DemandStatus::STATUS_TO_ASSIGN;
                // 只有测试环节
                $links = $request->input('demand_links');
                if (isset($links['test']) && !isset($links['dev']) && !isset($links['design'])) { // 未关联项目 状态为待测试
                    $updateData['status'] = DemandStatus::STATUS_TO_TEST;
                }
            }
            if (!$isProductManager) {
                // 当需求取消项目关联时
                if (!$request->has('source_project_id') && $demand->status == DemandStatus::STATUS_TO_PUSH) {
                    $updateData['status'] = DemandStatus::STATUS_TO_ASSIGN;
                }
            }
            if ($isProductManager && $request->has('source_project_id')) {
                $updateData['status'] = DemandStatus::STATUS_TO_PUSH;
            }
            // 更改需求负责人
            if($updateProducts) {
                $updateData['principal_user_id'] = $productManager->user_id;
                $updateData['principal_user_name'] = $productManager->user_name;
            }

            // 状态更新为带推送，待分配，待測試时更新SQ状态
            if (isset($updateData['status']) && in_array($updateData['status'], [DemandStatus::STATUS_TO_ASSIGN, DemandStatus::STATUS_TO_PUSH, DemandStatus::STATUS_TO_TEST])){
                $updateAppealStatus = true;
                $appealStatus = AppealStatus::STATUS_HAS_PROJECT;
            }
        } else {
            $isProductManager = $demand->principal_user_id == $this->user->id;
            if ($updateSourceProjectId) {
                // 当需求取消项目关联时
                if (!$request->has('source_project_id') && $demand->status == DemandStatus::STATUS_TO_PUSH) {
                    $updateData['status'] = DemandStatus::STATUS_TO_ASSIGN;
                    if ($isProductManager) {
                        $pushNow = true;
                    }
                }
            }
        }
        $updateData['updated_at'] = Carbon::now(); // 手动加上updated 避免无主表数据更新
        DB::beginTransaction();
        try {
            if ($updateProducts && $demand->status == DemandStatus::STATUS_TO_ASSIGN){
                // 删除原有的所有任务
                $demand->designTasks()->delete();
                $demand->testTasks()->delete();
                $demand->devTasks()->delete();
            } else if ($demand->status == DemandStatus::STATUS_TO_ASSIGN && !$updateProducts && $updateSourceProjectId) {
                $demand->designTasks()->update([
                   'source_project_id' => $updateData['source_project_id'] ?? 0
                ]);
                $demand->testTasks()->update([
                    'source_project_id' => $updateData['source_project_id'] ?? 0
                ]);
                $demand->devTasks()->update([
                    'source_project_id' => $updateData['source_project_id'] ?? 0
                ]);
            }
            $this->markLinks($demand, $request, $updateProducts);
            $this->updateAttentionUser($demand, $request);
            $this->uploadMedia($demand, $request);
            $demand->update($updateData);
            $this->setRelateProduct($demand, $request);
            if($pushNow){
                $this->createMainTask($demand);
            }
            // 如果没有更新产品信息，但是更新了环节信息，原来如果有任务环节那么更新任务信息
            if (!$updateProducts && $demand->status > DemandStatus::STATUS_TO_PUSH && $hasUpdateDemandLink){
                $this->updateTask($demand);
            }
            if ($updateAppealStatus){
                $demand->appeals()->get()->map(function ($item)use ($appealStatus){
                    $item->update([
                        'status' => $appealStatus
                    ]);
                });
            }
            // 版本号修改
            if ($versionIds = $request->input('release_version_ids')) {
                $demand->versions()->sync($versionIds);
            } else {
                $demand->versions()->detach();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            $demand->forgetUpdatedCache($key);
            if ($exception instanceof InvaildParameterException){
                throw  $exception;
            } else {
                \Log::error("更新Demand失败:" . $exception);
                throw new InvaildParameterException('更新失败！请稍后再试');
            }
        }
        DB::commit();
        $demand->forgetUpdatedCache($key);
        return true;
    }

    /**
     * 更新关注的人
     * @param Demand $demand
     * @param Request $request
     * @throws InvaildParameterException
     */
    protected function updateAttentionUser(Demand $demand, Request $request)
    {
        $attentions = $demand->attentionAble()->get();
        $oldAttentionUser = $attentions->pluck('user_id')->toArray();
        $oldAttentionName = $attentions->pluck('user_name')->toArray();
        $nowAttentionUser = $request->input('attention_user_ids', []);
        $deleteAttentionUser = array_diff($oldAttentionUser, $nowAttentionUser);
        $addAttentionUser = array_diff($nowAttentionUser, $oldAttentionUser);
        if (!empty($deleteAttentionUser) || !empty($addAttentionUser)){ // 关注的人出现变动
            $newUserName = User::query()->whereIn('id', $nowAttentionUser)->get()->pluck('name')->toArray();
            $attentionChanges = [
                'name' => '需关注的人',
                'old'  => implode(',' , $oldAttentionName),
                'new'  => implode(',', $newUserName)
            ];
            $key = 'demand_id_' . $demand->id . '_user_id_' .$this->user->id;
            $demand->updateCacheOfUpdated($key, $attentionChanges);
        }
        if (!empty($deleteAttentionUser)){
            $demand->attentionAble()->whereIn('user_id', $deleteAttentionUser)->delete();
        }
        if (!empty($addAttentionUser)){
            $this->addAttentionUser($demand, $addAttentionUser);
        }
    }

    /**
     * 创建对应的主task
     * @param Demand $demand
     */
    protected function createMainTask(Demand $demand, $links = null)
    {
        // 需求推送的任务为待审核状态
        // 再由任务的主负责人进行审核（确定实际负责人）
        $links = $links ? $links : $demand->demandLinks()->orderBy('type', "ASC")->get();
        $needDesign = false;
        $needDev = false;
        $links->map(function ($item) use ($demand, &$needDesign, &$needDev) {
            $taskPriority = !empty($demand->priority) ? $demand->priority : 0;
            if ($item->type == DemandLinksType::TYPE_DESIGN) {
                $needDesign = true;
                $product = $demand->products()->orderBy('type',"DESC")->get();
                DesignTask::query()->create([
                    'demand_id' => $demand->id,
                    'source_project_id'   => $demand->source_project_id ?? 0,
                    'promulgator_id'      => $demand->promulgator_id,
                    'promulgator_name'    => $demand->promulgator_name,
                    // 设计的"主"负责人字段(main_principal_user)是无用的
                    // principal_user就是主负责人，实际负责人是各个环节的负责人
                    'main_principal_user_id' => $item->principal_user_id,
                    'main_principal_user_name' => $item->principal_user_name,
                    'principal_user_id'   => $item->principal_user_id,
                    'principal_user_name' => $item->principal_user_name,
                    'content'             => $demand->content,
                    'status'              => DesignTaskStatus::STATUS_TO_AUDIT, // 处于第一环节，跳过关闭状态
                    'review'              => $product[0]->design_review,
                    'priority'            => $taskPriority,
                ]);
            }
            if ($item->type == DemandLinksType::TYPE_DEVELOP) {
                $needDev = true;
                DevTask::query()->create([
                    'demand_id'           => $demand->id,
                    'source_project_id'   => $demand->source_project_id ?? 0,
                    'promulgator_id'      => $demand->promulgator_id,
                    'promulgator_name'    => $demand->promulgator_name,
                    'main_principal_user_id' => $item->principal_user_id,
                    'main_principal_user_name' => $item->principal_user_name,
                    'content'             => $demand->content,
                    'status'              => DevTaskStatus::STATUS_TO_AUDIT,
                    'priority'            => $taskPriority,
                ]);
            }
            if ($item->type == DemandLinksType::TYPE_TEST) {
                TestTask::query()->create([
                    'demand_id'           => $demand->id,
                    'source_project_id'   => $demand->source_project_id ?? 0,
                    'promulgator_id'      => $demand->promulgator_id,
                    'promulgator_name'    => $demand->promulgator_name,
                    'main_principal_user_id' => $item->principal_user_id,
                    'main_principal_user_name' => $item->principal_user_name,
                    'content'             => $demand->content,
                    'status'              => TestTaskStatus::STATUS_TO_AUDIT,
                    'priority'            => $taskPriority,
                ]);
            }
            if ($item->type == DemandLinksType::TYPE_FRONTEND) {
                FrontendTask::query()->create([
                    'demand_id'           => $demand->id,
                    'source_project_id'   => $demand->source_project_id ?? 0,
                    'promulgator_id'      => $demand->promulgator_id,
                    'promulgator_name'    => $demand->promulgator_name,
                    'main_principal_user_id' => $item->principal_user_id,
                    'main_principal_user_name' => $item->principal_user_name,
                    'content'             => $demand->content,
                    'status'              => FrontendTaskStatus::STATUS_TO_AUDIT,
                    'priority'            => $taskPriority,
                ]);
            }
            if ($item->type == DemandLinksType::TYPE_MOBILE) {
                MobileTask::query()->create([
                    'demand_id'           => $demand->id,
                    'source_project_id'   => $demand->source_project_id ?? 0,
                    'promulgator_id'      => $demand->promulgator_id,
                    'promulgator_name'    => $demand->promulgator_name,
                    'main_principal_user_id' => $item->principal_user_id,
                    'main_principal_user_name' => $item->principal_user_name,
                    'content'             => $demand->content,
                    'status'              => MobileTaskStatus::STATUS_TO_AUDIT,
                    'priority'            => $taskPriority,
                ]);
            }
        });
    }

    /**
     * 更新所有关联的task part 的状态
     * @param Demand $demand
     * @param $action
     */
    protected function updateTaskStatus(Demand $demand, $action)
    {
        $demand->designPart()->get()->map(function ($item)use($action)
        {
           $item->update(
               [
                   'status' => constant(DesignPartStatus::class.'::'. $action)
               ]
           );
        });
        $demand->designSubtasks()->get()->map(function ($item)use($action){
           $item->update(
               [
                   'status' => constant(DesignSubTaskStatus::class.'::'. $action)
               ]
           );
        });
        $demand->designTasks()->get()->map(function ($item)use($action){
            $item->update(
                [
                    'status' => constant(DesignTaskStatus::class.'::'. $action)
                ]
            );
        });
        $demand->devSubtasks()->get()->map(function ($item)use ($action){
           $item->update(
               [
                   'status' => constant(DevSubTaskStatus::class."::".$action)
               ]
           );
        });
        $demand->devTasks()->get()->map(function ($item)use ($action){
           $item->update(
               [
                   'status' => constant(DevTaskStatus::class."::".$action)
               ]
           );
        });
        $demand->testTasks()->get()->map(function ($item)use($action){
            $item->update(
                [
                    'status' => constant(TestTaskStatus::class."::".$action)
                ]
            );
        });

        $demand->testSubtasks()->get()->map(function ($item)use($action){
            $item->update(
                [
                    'status' => constant(TestSubTaskStatus::class."::".$action)
                ]
            );
        });
        $demand->frontendSubtasks()->get()->map(function ($item)use ($action){
            $item->update(
                [
                    'status' => constant(FrontendSubTaskStatus::class."::".$action)
                ]
            );
        });
        $demand->frontendTasks()->get()->map(function ($item)use ($action){
            $item->update(
                [
                    'status' => constant(FrontendTaskStatus::class."::".$action)
                ]
            );
        });
        $demand->mobileSubTasks()->get()->map(function ($item)use ($action){
            $item->update(
                [
                    'status' => constant(MobileSubTaskStatus::class."::".$action)
                ]
            );
        });
        $demand->mobileTasks()->get()->map(function ($item)use ($action){
            $item->update(
                [
                    'status' => constant(MobileTaskStatus::class."::".$action)
                ]
            );
        });
    }

    /**
     * 恢复task的状态
     * @param Demand $demand
     */
    protected function continueTask(Demand $demand)
    {
        $demand->designPart()->get()->map(function ($item)
        {
            $pauseStatus = DesignPartStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id',"DESC")->first();
            $item->update(
                [
                    'status' => $history_logs->old_status
                ]
            );
        });

        $demand->designSubtasks()->get()->map(function ($item){
            $pauseStatus = DesignSubTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id',"DESC")->first();
            if ($history_logs) {
                $item->update(
                    [
                        'status' => $history_logs->old_status
                    ]
                );
            }
        });
        $demand->designTasks()->get()->map(function ($item){
            $pauseStatus = DesignTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id',"DESC")->first();
            $item->update(
                [
                    'status' => $history_logs->old_status
                ]
            );
        });
        $demand->devSubtasks()->get()->map(function ($item){
            $pauseStatus = DevSubTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id',"DESC")->first();
            if ($history_logs) {
                $item->update(
                    [
                        'status' => $history_logs->old_status
                    ]
                );
            }
        });
        $demand->devTasks()->get()->map(function ($item){
            $pauseStatus = DevTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id',"DESC")->first();
            $item->update(
                [
                    'status' => $history_logs->old_status
                ]
            );
        });
        $demand->testTasks()->get()->map(function ($item){
            $pauseStatus = TestTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id',"DESC")->first();
            $item->update(
                [
                    'status' => $history_logs->old_status
                ]
            );
        });

        $demand->testSubtasks()->get()->map(function ($item){
            $pauseStatus = TestSubTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id',"DESC")->first();
            if ($history_logs) {
                $item->update(
                    [
                        'status' => $history_logs->old_status
                    ]
                );
            }
        });
        $demand->frontendSubtasks()->get()->map(function ($item) {
            $pauseStatus = FrontendSubTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id', "DESC")->first();
            if ($history_logs) {
                $item->update(
                    [
                        'status' => $history_logs->old_status,
                    ]
                );
            }
        });
        $demand->frontendTasks()->get()->map(function ($item) {
            $pauseStatus = FrontendTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id', "DESC")->first();
            $item->update(
                [
                    'status' => $history_logs->old_status,
                ]
            );
        });
        $demand->mobileSubtasks()->get()->map(function ($item) {
            $pauseStatus = MobileSubTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id', "DESC")->first();
            if ($history_logs) {
                $item->update(
                    [
                        'status' => $history_logs->old_status,
                    ]
                );
            }
        });
        $demand->mobileTasks()->get()->map(function ($item) {
            $pauseStatus = MobileTaskStatus::STATUS_PAUSED;
            $history_logs = $item->statusLogs()->where('new_status', $pauseStatus)->orderBy('id', "DESC")->first();
            $item->update(
                [
                    'status' => $history_logs->old_status,
                ]
            );
        });
    }

    /**
     * 递归查询对应的负责人 // 2020-05-08 改为直接查询产品负责人
     * @param $productId
     * @param $type
     * @return |null
     */
    protected function getPrincipalInfoByProductId($productId, $type)
    {
        $product = Product::query()->find($productId);
        $team = $product->teams()->where('type', $type)->where('is_default', 1)->first(); // 默认负责人
        if (is_null($team)){
            $team = $product->teams()->where('type', $type)->first();
        }
        if (!is_null($team)){
            return $team;
        } else {
            return null;
        }
    }

    /**
     * 获取需求任务的附件
     * @param Demand $demand
     * @return array
     */
    protected function getTaskDocs(Demand $demand)
    {
        $design = $dev = $test = $frontend = $mobile = [
            'share_address' => [],
            'media'         => [],
        ];
        $links = $demand->demandLinks()->get();
        $hasDesignLink = $links->where('type', DemandLinksType::TYPE_DESIGN)->isNotEmpty();
        $hasDevLink = $links->where('type', DemandLinksType::TYPE_DEVELOP)->isNotEmpty();
        $hasTestLink = $links->where('type', DemandLinksType::TYPE_TEST)->isNotEmpty();
        $hasFrontLink = $links->where('type', DemandLinksType::TYPE_FRONTEND)->isNotEmpty();
        $hasMobileLink = $links->where('type', DemandLinksType::TYPE_MOBILE)->isNotEmpty();
        if ($hasDesignLink) {
            $demand->designSubtasks()->with('media')->get()->map(function ($item)use(&$design){
                $share_address = $item->share_address ? ((is_array($item->share_address) ? $item->share_address : json_decode($item->share_address))) : [];
                $design['share_address'] = array_merge($design['share_address'],$share_address);
                MediaResource::collection($item->media)->map(function ($item1)use(&$design){
                    $design['media'][] = $item1;
                });
            });
            if (empty($design['share_address'])){
                $design['share_address'] = null;
            }
        }
        if ($hasDevLink) {
            $demand->devSubtasks()->with('media')->get()->map(function ($item)use(&$dev){
                $share_address = $item->share_address ? ((is_array($item->share_address) ? $item->share_address : json_decode($item->share_address))) : [];
                $dev['share_address'] = array_merge($dev['share_address'],$share_address);
                MediaResource::collection($item->media)->map(function ($item1)use(&$dev){
                    $dev['media'][] = $item1;
                });
            });
            if (empty($dev['share_address'])){
                $dev['share_address'] = null;
            }
        }
        if ($hasTestLink) {
            $demand->testSubtasks()->with('media')->get()->map(function ($item)use(&$test){
                $share_address = $item->share_address ? ((is_array($item->share_address) ? $item->share_address : json_decode($item->share_address))) : [];
                $test['share_address'] = array_merge($test['share_address'],$share_address);
                MediaResource::collection($item->media)->map(function ($item1)use(&$test){
                    $test['media'][] = $item1;
                });
            });
            if (empty($test['share_address'])){
                $test['share_address'] = null;
            }
        }
        if ($hasFrontLink) {
            $demand->frontendSubtasks()->with('media')->get()->map(function ($item) use (&$frontend) {
                $share_address = $item->share_address ? ((is_array($item->share_address) ? $item->share_address : json_decode($item->share_address))) : [];
                $frontend['share_address'] = array_merge($frontend['share_address'], $share_address);
                MediaResource::collection($item->media)->map(function ($item1) use (&$frontend) {
                    $frontend['media'][] = $item1;
                });
            });
            if (empty($frontend['share_address'])) {
                $frontend['share_address'] = null;
            }
        }
        if ($hasMobileLink) {
            $demand->frontendSubtasks()->with('media')->get()->map(function ($item) use (&$mobile) {
                $share_address = $item->share_address ? ((is_array($item->share_address) ? $item->share_address : json_decode($item->share_address))) : [];
                $mobile['share_address'] = array_merge($mobile['share_address'], $share_address);
                MediaResource::collection($item->media)->map(function ($item1) use (&$mobile) {
                    $mobile['media'][] = $item1;
                });
            });
            if (empty($mobile['share_address'])) {
                $mobile['share_address'] = null;
            }
        }
        $data = [];
        if ($hasDesignLink) {
            $data['design'] = $design;
        }
        if ($hasDevLink) {
            $data['dev'] = $dev;
        }
        if ($hasTestLink) {
            $data['test'] = $test;
        }
        if ($hasFrontLink) {
            $data['frontend'] = $frontend;
        }
        if ($hasMobileLink) {
            $data['mobile'] = $mobile;
        }
        return $data;
    }

    /**
     * 关注或取消关注
     * @param Request $request
     * @return bool
     * @throws InvaildParameterException
     */
    public function attention(Request $request)
    {
        $demand = Demand::query()->find($request->id);
        if (is_null($demand)){
            throw new InvaildParameterException("未找到对应的需求，请检查参数是否正确");
        }
        if($demand->is_attention){
            $demand->attentionAble()
                ->where('user_id', $this->user->id)
                ->delete();
            $desc = Carbon::now() . " 用户{$this->user->name} 取消了对需求的关注";
        } else {
            $userDept = $this->user->basicDepartment;
            if (!$userDept){
                throw new InvaildParameterException("您未绑定部门信息，无法关注项目！");
            }
            $demand->attentionAble()->create([
                'user_id' => $this->user->id,
                'user_name' => $this->user->name,
                'dept_id' => $userDept->id,
                'dept_name' => $userDept->name,
            ]);
            $desc = Carbon::now() . " 用户{$this->user->name} 关注了该需求";
        }
        app(ActivityLogger::class)
            ->useLog('operation_log')
            ->performedOn($demand)
            ->log($desc);
        return true;
    }

    /**
     * 根据request 判断是否更新了demand_link
     * @param Demand $demand
     * @param Request $request
     * @return bool
     */
    public function hasUpdateDemandLink(Demand $demand, Request $request)
    {
        $new_demand_links = $demand_links = [];
        $links = $request->input('demand_links');
        if (isset($links['design'])) {
            $new_demand_links['design'] = true;
        }
        if (isset($links['dev'])){
            $new_demand_links['dev'] = true;
        }
        if (isset($links['test'])){
            $new_demand_links['test'] = $links['test']['group'];
        }
        if (isset($links['frontend'])) {
            $new_demand_links['frontend'] = true;
        }
        if (isset($links['mobile'])) {
            $new_demand_links['mobile'] = true;
        }
        $demand->demandLinks()->get()->map(function ($item)use(&$demand_links){
            switch ($item->type){
                case DemandLinksType::TYPE_DESIGN:
                    $demand_links['design'] = true;
                    break;
                case DemandLinksType::TYPE_DEVELOP:
                    $demand_links['dev'] = true;
                    break;
                case DemandLinksType::TYPE_TEST:
                    $demand_links['test'] = $item->group;
                    break;
                case DemandLinksType::TYPE_FRONTEND:
                    $demand_links['frontend'] = true;
                    break;
                case DemandLinksType::TYPE_MOBILE:
                    $demand_links['mobile'] = true;
                    break;
            }
        });
        $del_links = array_diff_assoc($demand_links,$new_demand_links);
        $add_links = array_diff_assoc($new_demand_links, $demand_links);
        $this->del_links = $del_links;
        $this->add_links = $add_links;
        return (!empty($del_links) || !empty($add_links));
    }

    /**
     * 重新生成任务
     * @param Demand $demand
     */
    protected function updateTask(Demand $demand)
    {
        if (!empty($this->del_links)){
            foreach ($this->del_links as $key => $links){
                switch ($key){
                    case 'design':
                        $demand->designSubtasks()->delete();
                        $demand->designPart()->delete();
                        $demand->designTasks()->delete();
                        break;
                    case 'dev':
                        $demand->devSubtasks()->delete();
                        $demand->devTasks()->delete();
                        break;
                    case "test":
                        $demand->testSubtasks()->delete();
                        $demand->testTasks()->delete();
                        break;
                    case 'frontend':
                        $demand->frontendSubtasks()->delete();
                        $demand->frontendTasks()->delete();
                        break;
                    case 'mobile':
                        $demand->mobileSubTasks()->delete();
                        $demand->mobileTasks()->delete();
                        break;
                }
            }
        }

        if (!empty($this->add_links)){
            foreach ($this->add_links as $key => $links){
                switch ($key){
                    case 'design':
                        $search_type[] = DemandLinksType::TYPE_DESIGN;
                        break;
                    case 'dev':
                        $search_type[] = DemandLinksType::TYPE_DEVELOP;
                        break;
                    case "test":
                        $search_type[] = DemandLinksType::TYPE_TEST;
                        break;
                    case 'frontend':
                        $search_type[] = DemandLinksType::TYPE_FRONTEND;
                        break;
                    case 'mobile':
                        $search_type[] = DemandLinksType::TYPE_MOBILE;
                        break;
                }
            }
            $pushLinks = $demand->demandLinks()->whereIn('type', $search_type)->orderBy('type', "ASC")->get();
            $this->createMainTask($demand, $pushLinks);
        }

        // 环节更新 任务被删除 重新判断一下是否更新demand 的状态

        $not_completed_design = $demand->designTasks()
            ->whereNotIn('status', [
                DesignTaskStatus::STATUS_COMPLETED,
                DesignTaskStatus::STATUS_REVOCATION
            ])->count();
        $not_completed_dev = $demand->devTasks()
            ->whereNotIn('status', [
                DevTaskStatus::STATUS_COMPLETED,
                DevTaskStatus::STATUS_REVOCATION,
            ])->count();
        if($not_completed_design == 0 && $not_completed_dev == 0) {
            $demand->update([
                'status' => DemandStatus::STATUS_SUBMIT
            ]);
        }
    }

    /**
     * @param Demand $demand
     * @param $data
     */
    public function setPrincipal(Demand $demand, $data)
    {
        if (!$this->user->can('setPrincipal', $demand)) {
            throw new DemandPermissionException('权限错误！');
        }
        $user = User::query()->find($data['user_id']);
        $demand->update([
            'principal_user_id' => $user->id,
            'principal_user_name' => $user->name,
        ]);
    }

    /**
     * 需求转移
     * @param $data
     * @throws InvalidParameterException
     */
    public function transfer($data)
    {
        $demands = Demand::query()->whereIn('id', $data['demand_ids'])->get();
        if ($demands->unique('promulgator_id')->count() > 1) {
            throw new InvalidParameterException('请确认需转移的需求发布人为同一人！');
        }
        if ($demands->where('status', DemandStatus::STATUS_REVOCATION)->count() > 0) {
            throw new InvalidParameterException('已撤销需求，不可操作转移！');
        }
        if ($demands->where('status', DemandStatus::STATUS_COMPLETED)->count() > 0) {
            throw new InvalidParameterException('已完成需求，不可操作转移！');
        }
        $receiver = User::query()->find($data['receiver_id']);
        $demandData = [
            'promulgator_id' => $receiver->id,
            'promulgator_name' => $receiver->name,
        ];
        $demands->each(function (Demand $demand) use ($demandData, $receiver) {
            $demand->update($demandData);
            // 诉求立项过来的需求，需求发布人也是诉求的产品跟进人，需要同步变更
            $appeals = $demand->appeals()->get();
            if ($appeals->isNotEmpty()) {
                $appeals->each(function (Appeal $appeal) use ($receiver) {
                    $appeal->update([
                        'follower_id' => $receiver->id,
                        'follower_name' => $receiver->name,
                    ]);
                });
            }
        });
    }
}
