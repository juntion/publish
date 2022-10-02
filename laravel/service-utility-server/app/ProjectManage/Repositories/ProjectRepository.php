<?php


namespace App\ProjectManage\Repositories;


use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\ProjectStatus;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Events\PM\CreateProject;
use App\Exceptions\Project\InvaildParameterException;
use App\Exceptions\Project\ProjectPermissionException;
use App\Http\Resources\ActivityLogResource;
use App\Http\Resources\MediaResource;
use App\Models\User;
use App\ProjectManage\Models\ActivityLog;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Project;
use App\Repositories\BaseRepository;
use App\Support\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ProjectRepository extends BaseRepository
{
    protected $model;
    protected $user;
    protected $allowedSearches = ['attentionAble.user_id', 'promulgator_id', 'status', 'type'];
    protected $allowedScopeSearches = ['participant', 'keyword'];
    protected $allowedSorts = ['difficulty', 'level', 'created_at'];
    protected $principals = [
        0 => 'product_user_ids',
        1 => 'design_user_ids',
        2 => 'dev_user_ids',
        3 => 'business_user_ids',
        4 => 'test_user_ids'
    ];

    protected $shouldAppends = ['policies'];

    protected $allowedMust = ['number', 'name', 'level', 'difficulty', 'promulgator_id', 'principal_user_id', 'projectPrincipals.user_id', 'status', 'created_at', 'finish_time', 'contents', 'attentionAble.user_id'];
    protected $allowedScopeMust = ['productLine', 'productName'];
    public function __construct(Project $project)
    {
        $this->model = $project;
        $this->user = Auth::user();
    }

    /**
     * 关注或者取消关注
     * @throws InvaildParameterException
     */
    public function attention()
    {
        $id = request('id');
        $project = Project::query()->find($id);
        if (!$project){
            throw new InvaildParameterException('参数错误！未找到对应的项目！');
        }
        $user =$this->user;
        $attention = $project->attentionAble()->where('user_id', $user->id);
        if (!$attention->get()->isEmpty()) {
            $attention->delete();
        } else {
            $userDept = $user->basicDepartment;
            if (is_null($userDept)){
                throw new InvaildParameterException('用户信息错误，无对应部门信息');
            }
            $attention->create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'dept_id' => $userDept->id,
                'dept_name' => $userDept->name,
            ]);
        }
    }

    /**
     * 返回项目具体信息
     * @return array
     * @throws InvaildParameterException
     */
    public function details()
    {
        $id = request('id');
        $project = Project::query()
            ->with('products')
            ->with('projectPrincipals')
            ->with('media')
            ->find($id);
        if (is_null($project)){
            throw new InvaildParameterException('参数错误！未找到对应的项目！');
        }
        $statistics = [];
        $demand_docs = [];
        if (request()->input('demand_docs') == 1){
            $demand_docs = $this->getDemandDocs($project);
        }
        // todo 返回统计数据
        if (request()->input('statistics') == 1){
            $statistics = $this->getProjectStatisticsInfo($project);
        }
        $user_attentions = $project->attentionAble;
        $all_media = $project->media->groupBy('collection_name');
        if ($all_media->isNotEmpty()){
            $media = isset($all_media[$project->getProjectMedia()]) ? MediaResource::collection($all_media[$project->getProjectMedia()]) : [];
            $project_summary = isset($all_media['project_summary']) ? MediaResource::collection($all_media['project_summary']):[];
        } else {
            $media = [];
            $project_summary = [];
        }
        $changes = ActivityLogResource::collection($project->changes()->orderBy('created_at', 'desc')->get());
        $project->append(['policies','product_category']);
        $project->is_attention = $project->getIsAttention();
        $project = $project->toArray();
        $project['user_attentions'] = $user_attentions;
        $project['media'] = $media;
        $project['operation_logs'] = $changes;
        $project['project_summary'] = empty($project_summary) ? null : $project_summary[0];
        unset($project['attention_able']);
        unset($project['changes']);
        $data = compact('project', 'statistics', 'demand_docs');
        return $data;
    }

    /**
     * 获取demand文档
     * @param Project $project
     * @return array
     */
    protected  function getDemandDocs(Project $project){
        $doc = [];
        $project->demands()->where('status', '!=', DemandStatus::STATUS_REVOCATION)->with('media')->get()
            ->map(function ($item) use (&$doc) {
                MediaResource::collection($item->media)->map(function ($v) use (&$doc) {
                    $doc[] = $v;
                });
            });
        return $doc;
    }
    /**
     * 返回列表
     * @return mixed
     */
    public function index()
    {
        $limit = request()->input('limit');
        $data = $this->orderBy('id', 'desc')->getModelsList($limit);
        $data->load('attentionAble');
        $this->handleAppends($data);
        foreach ($data as $project) {
            $project->is_attention = $project->attentionAble->where('user_id', Auth::id())->isNotEmpty();
            unset($project->attentionAble);
        }
        return $data->toArray();
    }

    /**
     * 返回最新几条的日志记录
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getDynamicLog()
    {
        $limit = request()->input('limit');
        $data = ActivityLog::query()
            ->select(['description', 'created_at','causer_id'])
            ->where('log_name','dynamic_log')
            ->where('causer_id', $this->user->id)
            ->where('subject_type',Project::class)
            ->orderBy('created_at','DESC')
            ->paginate($limit);
        return $data;
    }

    /**
     * 具体项目的日志信息
     * @return array
     * @throws InvaildParameterException
     */
    public function getProjectLogs()
    {
        $id = request('id');
        $project = Project::query()->find($id);
        if (is_null($project)){
            throw new InvaildParameterException('参数错误！未找到对应的项目！');
        }
        $data = [];
        $project->statusLogs()->orderBy('created_at',"DESC")->get()->map(function ($item)use(&$data){
            $info['user_name'] = $item->user_name;
            $info['status'] = $item->new_status_desc;
            $info['comment'] = $item->comment;
            $info['created_at'] = $item->created_at;
            $data['status_logs'][] = $info;
        });
        return $data;
    }

    /**
     * @param Request $request
     * @param int $isMajor
     * @return bool
     * @throws InvaildParameterException
     */
    public function createProject(Request $request, $isMajor = 1)
    {
        $insertData = $request->only(['name', 'principal_user_id', 'expiration_date', 'contents', 'status', 'shared_address', 'level', 'difficulty']);
        $insertData['promulgator_id'] = $this->user->id;
        $insertData['promulgator_name'] = $this->user->name;
        $insertData['type'] = $isMajor;
        $principal_user = User::query()->find($request->input('principal_user_id'));
        $insertData['principal_user_name'] = $principal_user->name;
        DB::beginTransaction();
        try{
            $project = Project::query()->create($insertData);
            $this->projectPrincipals($project, $request);
            if ($request->has('attention_user_ids')){
                $this->addAttentionUser($project, $request->input('attention_user_ids'));
            }
            $this->uploadMedia($project, $request);
            $this->relateProduct($project, $request);
            // 添加一份日志信息用来提醒人员
            $desc = $project->promulgator_name . '于' . $project->created_at . '发布了一个"' . $project->name . '" 项目需要您负责';
            $this->addActivity($principal_user, $project, $desc);
            // 发布时记录初始状态
            $project->statusLogs()->create([
                'user_id' => $this->user->id,
                'user_name' => $this->user->name,
                'action_name' => Route::current()->getName(),
                'new_status'  => $insertData['status'],
                'comment'     => "",
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::Error($exception);
            throw new InvaildParameterException($exception->getMessage());
        }
        DB::commit();

        // 邮件通知项目负责人
        event(new CreateProject($project));

        return true;
    }

    /*
     * 判断是否添加对应的人员
     */
    protected function projectPrincipals(Project $project, Request $request, $is_delete = false)
    {
        foreach ($this->principals as $k => $v) {
            if ($request->has($v)){
                $this->AddProjectPrincipals($project, $k, $request->input($v));
            } else if ($is_delete) {
                $principal = $project->projectPrincipals()
                    ->where('project_id', $project->id)
                    ->where('type', $k)
                    ->first();
                if (!is_null($principal)) {
                    $principal->delete();
                }
            }
        }
        return true;
    }

    /**
     * 执行添加人员
     * @param Project $project
     * @param $type
     * @param $uid
     */
    protected function AddProjectPrincipals(Project $project, $type, $ids)
    {

        $project_principals = $project->projectPrincipals()
            ->where('project_id', $project->id)
            ->where('type', $type)
            ->whereNotIn('user_id', $ids)
            ->delete();
        foreach ($ids as $uid){
            $user = User::query()->find($uid);
            $userDept = $user->department->first();
            $project_principals = $project->projectPrincipals()
                ->where('project_id', $project->id)
                ->where('type', $type)
                ->where('user_id', $uid)
                ->first();
            if(!is_null($project_principals) && $project_principals->user_id != $uid){
                $project_principals->delete();
            } else if(!is_null($project_principals) && $project_principals->user_id == $uid) {
                continue;
            }
            $project->projectPrincipals()->create(
                [
                    'project_id' => $project->id,
                    'user_id'    => $user->id,
                    'user_name'  => $user->name,
                    'dept_id'    => $userDept->id,
                    'dept_name'  => $userDept->name,
                    'type'       => $type
                ]
            );
        }
    }
    /**
     * @param User $user
     * @param Project $project
     * @param string $desc
     */
    protected function addActivity(User $user, Project $project, $desc)
    {
        activity()
            ->useLog('dynamic_log')
            ->performedOn($project)
            ->causedBy($user)
            ->log($desc);
    }

    /**
     * 添加关注并记录一下关注日志
     * @param Project $project
     * @param $uids
     * @throws InvaildParameterException
     */
    protected function addAttentionUser(Project $project, $uids)
    {
        foreach ($uids as $v){
            $user = User::query()->find($v);
            $userDept = $user->department->first();
            if (!$userDept){
                throw new InvaildParameterException("所选用户{$user->name} 没有绑定部门信息，请查证后再试！");
            }
            $project->attentionAble()->create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'dept_id' => $userDept->id,
                'dept_name' => $userDept->name,
            ]);
            $desc = $project->promulgator_name . '于' . $project->created_at . '发布了一个"' . $project->name . '" 项目需要您关注';
            $this->addActivity($user,$project,$desc);
        }
    }

    /**
     * 项目关联Media
     * @param Project $project
     * @param Request $request
     */
    protected function uploadMedia(Project $project, Request $request)
    {
        $update = false;
        $old = [];
        $new = [];

        $old = $project->media()->get()->pluck('name')->toArray();
        if (!$request->has('old_media') && !empty($old)){
            $update = true;
            $project->media()->delete();
        } else if($request->has('old_media')) {
            $del_media = $project->media()->whereNotIn('id', $request->input('old_media'));
            $num = $del_media->count();
            if ($num > 0) {
                $update = true;
                $del_media->delete();
            }
        }

        if ($request->file('new_media')){
            $update = true;
            collect($request->file('new_media'))->map(function ($media)use ($project){
                $path = Upload::addFile($media)->save();
                $project->moveTmpMedia($project->getProjectMedia(), $path, true);
            });
        }
        if ($update) {
            $new = $project->media()->get()->pluck('name')->toArray();
            $mediaChanges = [
                'name' => '附件更新',
                'old'  => implode(',', $old),
                'new'  => implode(',', $new)
            ];
            $key = 'project_id_' . $project->id . '_user_id_' .$this->user->id;
            $project->updateCacheOfUpdated($key, $mediaChanges);
        }
        if ($request->file('media')){
            collect($request->file('media'))->map(function ($media)use ($project){
               $path = Upload::addFile($media)->save();
               $project->moveTmpMedia($project->getProjectMedia(), $path, true);
            });
        }
    }

    /*
     * 添加项目与产品的多对多关系
     */
    protected function relateProduct(Project $project, Request $request)
    {
        $products = [];
        if($request->has('product_ids')){
            foreach ($request->input('product_ids') as $v){
                $product = Product::query()->find($v);
                $products[$product->id] = [
                    'product_type' =>$product->type
                ];
                $products = $this->getAllParentsOfProduct($product, $products);
            }
        }
        $project->products()->sync($products);
    }

    /*
     * 递归查出所有的PID
     */
    protected function getAllParentsOfProduct(Product $product, $pid = [])
    {
        $project = Product::query()->find($product->parent_id);
        $parent_id = $project->parent_id;
        if ($parent_id != 0) {
            $pid[$project->id] = [
                'product_type' => $project->type
            ];
            $pid = $this->getAllParentsOfProduct($project, $pid);
        } else {
            $pid[$project->id] = [
                'product_type' => $project->type
            ];
        }
        return $pid;
    }

    public function updateProject(Request $request)
    {
        $id = $request->id;
        $project = Project::query()
            ->whereNotIn('status', [ProjectStatus::STATUS_COMPLETED, ProjectStatus::STATUS_REVOCATION])
            ->find($id);
        if (is_null($project)){
            throw new InvaildParameterException('参数错误，未找到对应的项目或该项目无法更新');
        }
        if (!$this->user->can('updateProject', $project)){
            throw new ProjectPermissionException('权限错误！您无权更新该项目');
        }
        // 非必填的默认
        $updateData = [
            'expiration_date' => null,
            'shared_address'  => []
        ];
        $updateData = array_merge($updateData,$request->all());
        $principal_user = User::query()->find($request->input('principal_user_id'));
        $updateData['principal_user_name'] = $principal_user->name;
        $key = 'project_id_' . $project->id . '_user_id_' .$this->user->id;
        $project->forgetUpdatedCache($key);
        $updateData['updated_at'] = Carbon::now(); // 手动加上updated 避免无主表数据更新
        DB::beginTransaction();
        try{
            if ($project->principal_user_id != $request->input('principal_user_id')){
                // 负责人变更通知
                $desc = $project->promulgator_name . '于' . $project->created_at . '发布了一个"' . $project->name . '" 项目需要您负责';
                $this->addActivity($principal_user, $project, $desc);
            }
            $this->relateProduct($project, $request);
            $this->updateAttentionUsers($project, $request);
            $this->projectPrincipals($project, $request, true);
            $this->uploadMedia($project, $request);
            $project->update($updateData);
            $this->setLog2RelateUser($project);
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::Error('更新失败：' . $exception);
            throw new InvaildParameterException('更新信息失败！稍后再试！');
        }
        DB::commit();
        $project->forgetUpdatedCache($key);

        // 修改负责人邮件通知
        if ($project->wasChanged('principal_user_id')) {
            event(new CreateProject($project));
        }

        return true;
    }

    /**
     * @param Project $project
     * @param Request $request
     * @throws InvaildParameterException
     */
    protected function updateAttentionUsers(Project $project, Request $request)
    {

        $attentions = $project->attentionAble()->get();
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
            $key = 'project_id_' . $project->id . '_user_id_' .$this->user->id;
            $project->updateCacheOfUpdated($key, $attentionChanges);
        }

        if (!empty($deleteAttentionUser)){
            $project->attentionAble()->whereIn('user_id', $deleteAttentionUser)->delete();
        }
        if (!empty($addAttentionUser)){
            $this->addAttentionUser($project, $addAttentionUser);
        }
    }

    /**
     * 删除指定项目的文件
     * @return bool
     */
    public function deleteMedia()
    {
        $pid = \request('id');
        $mid = \request('mid');
        Project::query()->find($pid)->media()->where('id', $mid)->delete();
        return true;
    }

    /**
     * 更新状态
     * @param Request $request
     * @throws InvaildParameterException
     * @throws ProjectPermissionException
     */
    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $project = Project::query()->where('id',$id)
            ->whereNotIn('status', [ProjectStatus::STATUS_COMPLETED, ProjectStatus::STATUS_REVOCATION])
            ->first();
        if(is_null($project)){
            throw  new InvaildParameterException('参数错误,无对应项目或项目不能更新状态');
        }
        if(!$this->user->can('updateStatus', $project)){
            throw  new ProjectPermissionException("权限错误！您无权更新该项目的状态");
        }
        if ($request->input('status') == ProjectStatus::STATUS_COMPLETED && !$request->file('project_summary')){ // 完成时必须带上 附件project_summary
            throw new ProjectPermissionException('更新状态为完成时必须带上项目总结文档');
        }
        DB::beginTransaction();
        try {
            $project->status = $request->input('status');
            if ($project->isDirty('status')){
//                $user = $this->user;
//                $project->statusLogs()->create([
//                    'user_id' => $user->id,
//                    'user_name' => $user->name,
//                    'action_name' => Route::current()->getName(),
//                    'old_status'  => $project->getOriginal('status'),
//                    'new_status'  => $request->input('status'),
//                    'comment'     => $request->input('comment', ''),
//                ]);
                // 通知关注改项目的人
                // 通知各类负责人
                $this->setLog2RelateUser($project, $request->input('status'));
                if ($request->input('status') == ProjectStatus::STATUS_COMPLETED){
                    $project->finish_time = Carbon::now();
                }
            }
            $project->save();
            if($request->file('project_summary')){
                $path = Upload::addFile($request->file('project_summary'))->save();
                $project->moveTmpMedia("project_summary", $path, true);
            }
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::error('更新项目状态失败:' . $exception);
            throw new InvaildParameterException('更新项目状态失败');
        }
        DB::commit();
    }

    /**
     * 项目状态变动时 通知到关联用户
     * @param $uid
     * @param Project $project
     * @param $status
     */
    protected function setLog2RelateUser(Project $project, $status = "")
    {
        $project->getRelateUsers()->map(function ($item)use($project, $status){
            if ($status != ""){
                $desc = "《" . $project->name . '》 项目于' . Carbon::now() . '变更为' . $project->getStatus($status);
            } else {
                $desc = "《" . $project->name . '》 项目于' . Carbon::now() . '由' .$this->user->name . '更新';
            }
            // 防止人员离职报错
            if ($user = User::query()->find($item)) {
                $this->addActivity($user, $project, $desc);
            }
        });
    }

    /**
     * 首页统计相关
     * @return array
     */
    public function statistics()
    {
        $countSql = ' COUNT(IF(status = ?, 1, null)) ';
        $statusArr = [
            ProjectStatus::STATUS_OFF,
            ProjectStatus::STATUS_ON,
            ProjectStatus::STATUS_PAUSED,
            ProjectStatus::STATUS_COMPLETED,
        ];
        $selectRaw = collect($statusArr)->map(function ($item) use ($countSql){
            return $countSql . 'AS status' . $item;
        })->implode(',');
        $countRes = $this->queryBuilder()
            ->selectRaw($selectRaw, $statusArr)
            ->whereIn('status', $statusArr)
            ->get()
            ->first();

        $statistics = [
            [
                'status' => ProjectStatus::STATUS_OFF,
                'name'   => ProjectStatus::getStatusDesc(ProjectStatus::STATUS_OFF),
                'count'  => $countRes->{'status' . ProjectStatus::STATUS_OFF}
            ],
            [
                'status' => ProjectStatus::STATUS_ON,
                'name'   => ProjectStatus::getStatusDesc(ProjectStatus::STATUS_ON),
                'count'  => $countRes->{'status' . ProjectStatus::STATUS_ON}
            ],
            [
                'status' => ProjectStatus::STATUS_PAUSED,
                'name'   => ProjectStatus::getStatusDesc(ProjectStatus::STATUS_PAUSED),
                'count'  => $countRes->{'status' . ProjectStatus::STATUS_PAUSED}
            ],
            [
                'status' => ProjectStatus::STATUS_COMPLETED,
                'name'   => ProjectStatus::getStatusDesc(ProjectStatus::STATUS_COMPLETED),
                'count'  => $countRes->{'status' . ProjectStatus::STATUS_COMPLETED}
            ],
        ];
        return compact('statistics');
    }

    /**
     * 返回指定项目的相关统计信息
     * @param Project $project
     * @return array
     */
    protected function getProjectStatisticsInfo(Project $project)
    {
        $needShowStatus = [
            DemandStatus::STATUS_TO_ACCEPT,
            DemandStatus::STATUS_REJECTED,
            DemandStatus::STATUS_TO_PUSH,
            DemandStatus::STATUS_TO_ASSIGN,
            DemandStatus::STATUS_NO_BEGIN,
            DemandStatus::STATUS_IN_PROGRESS,
            DemandStatus::STATUS_SUBMIT,
            DemandStatus::STATUS_TO_TEST,
            DemandStatus::STATUS_IN_TEST,
            DemandStatus::STATUS_COMPLETED,
            DemandStatus::STATUS_PAUSED,
            DemandStatus::STATUS_REVOCATION,
        ];
        $demand = [];
        $task = [];
        $allDemand = $project->demands()->get();
        foreach ($needShowStatus as $v) {
            $demand['status_count'][] = [
                'status' => $v,
                'name'   => DemandStatus::getStatusDesc($v),
                'count'  => $allDemand->filter(function ($val, $k)use($v){
                    return $val->status == $v;
                })->count()
            ];
        }
        $demand['total_count'] = $allDemand->count();
        $demand = $this->getInfoByCollection($demand, $allDemand, DemandStatus::STATUS_COMPLETED);
        $dev = $test = $design = [
            'total_count'     => 0,
            'completed_count' => 0,
            'average_period'  => '',
            'overdue_count'   => 0
        ];
        $allDesignTasks = $project->designSubtasks()->get();
        $allDevTasks = $project->devSubtasks()->get();
        $allTestTasks = $project->testSubtasks()->get();
        if ($allDesignTasks->isNotEmpty()){
            $design = $this->getInfoByCollection($design,$allDesignTasks,DesignSubTaskStatus::STATUS_COMPLETED);
        }
        if ($allTestTasks->isNotEmpty()){
            $test = $this->getInfoByCollection($test, $allTestTasks, TestSubTaskStatus::STATUS_COMPLETED);
        }
        if ($allDevTasks->isNotEmpty()){
            $dev = $this->getInfoByCollection($dev, $allDevTasks, DevSubTaskStatus::STATUS_COMPLETED);
        }
        $task = compact('design', 'dev', 'test');
        return compact('demand','task');
    }


    /**
     * 通过集合返回具体信息
     * @param array $info
     * @param Collection $TaskCollection
     * @param int $completed
     * @return array
     */
    protected function getInfoByCollection(array $info, Collection $TaskCollection, int $completed):array
    {
        $info['total_count'] = $TaskCollection->count();
        $UseDays = 0;
        $info['completed_count'] = $TaskCollection->filter(function ($val, $k)use (&$UseDays,$completed){
            if ($val->status == $completed){
                $UseDays += Carbon::parse($val->start_time)->diffInDays($val->finish_time) + 1;
                return true;
            }
            return false;
        })->count();
        if ($info['completed_count'] == 0) {
            $info['average_period'] = "";
        } else {
            $info['average_period'] = ceil($UseDays/$info['completed_count']);
        }
        $info['overdue_count'] = $TaskCollection->filter(function ($val, $k){
            return ($val->remaining_days < 0 && $val->finish_time == '') || ($val->expiration_date < date('Y-m-d', strtotime($val->finish_time)) && $val->expiration_date != '');
        })->count();
        return $info;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws ProjectPermissionException
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function projectSummary(Request $request)
    {
        $project = Project::query()->find($request->id);
        if(!$this->user->can('projectSummary',$project)){
            throw new ProjectPermissionException('当前您无法更新项目总结文件');
        }
        $path = Upload::addFile($request->file('project_summary'))->save();
        $project->moveTmpMedia("project_summary", $path, true);
        return true;
    }
}

