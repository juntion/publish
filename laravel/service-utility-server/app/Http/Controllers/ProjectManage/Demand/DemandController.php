<?php

namespace App\Http\Controllers\ProjectManage\Demand;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\TeamType;
use App\Exceptions\System\InvalidParameterException;
use App\Exports\DemandsExport;
use App\Exceptions\Demand\DemandPermissionException;
use App\Exceptions\Demand\InvaildParameterException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Demand\DemandRequest;
use App\Http\Requests\ProjectManage\Demand\DemandUpdateRequest;
use App\ProjectManage\Models\Demand;
use App\ProjectManage\Repositories\DemandRepository;
use App\ProjectManage\Repositories\TeamRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DemandController extends Controller
{
    protected $demand;
    protected $teams;

    public function __construct(DemandRepository $demand, TeamRepository $teams)
    {
        parent::__construct();
        $this->demand = $demand;
        $this->teams = $teams;
    }

    /**
     * 暂停需求
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     * @throws \App\Exceptions\Demand\DemandPermissionException
     */
    public function pauseDemand(Request $request)
    {
        $this->demand->pauseDemand($request);
        return $this->success();
    }

    /**
     * 取消需求
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     * @throws \App\Exceptions\Demand\DemandPermissionException
     */
    public function revocationDemand(Request $request)
    {
        $this->demand->revocationDemand($request);
        return $this->success();
    }

    /**
     * 继续需求
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     * @throws \App\Exceptions\Demand\DemandPermissionException
     */
    public function continueDemand(Request $request)
    {
        $this->demand->continueDemand($request);
        return $this->success();
    }

    /**
     * 需求详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function details(Request $request)
    {
        $data = $this->demand->demandDetails($request);
        return $this->successWithData($data);
    }

    /**
     * 审核需求
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     * @throws \App\Exceptions\Demand\DemandPermissionException
     */
    public function verify(Request $request)
    {
        $request->validate(['result' => 'required|in:0,1']);
        $this->demand->verify($request);
        return $this->success();
    }

    /**
     * 获取状态变更记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function logs(Request $request){
        $data = $this->demand->getStatusLogs($request);
        return $this->successWithData($data);
    }


    /**
     * 开启测试
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function beginTest(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $demand = Demand::query()->where('status', DemandStatus::STATUS_SUBMIT)->find($id);
            if (is_null($demand)) {
                throw new InvaildParameterException('参数错误！未找到对应的需求或需求无法开始测试！');
            }
            if (!$this->user()->can('beginTestDemand', $demand)) {
                throw new DemandPermissionException('权限错误! 您无权开启测试');
            }
            $this->demand->beginTest($demand);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvaildParameterException || $e instanceof DemandPermissionException) {
                return $this->failedWithMessage($e->getMessage());
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 需求完成
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\DemandPermissionException
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function complete(Request $request)
    {
        $id = $request->id;
        $demand = Demand::query()->where('status', DemandStatus::STATUS_IN_TEST)->find($id);
        if (is_null($demand)){
            throw new InvaildParameterException('参数错误！未找到对应的需求或需求不能变更为已完成！');
        }
        if (!$this->user()->can('completeDemand', $demand)){
            throw new DemandPermissionException('权限错误! 您无权将需求变更为已完成状态');
        }
        $this->demand->complete($demand);
        return $this->success();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function priority(Request $request)
    {
        $request->validate([
            'priority' => 'required|in:1,2,3,4,5'
        ]);
        $this->demand->priority($request);
        return $this->success();
    }

    /**
     * 获取所有的任务
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function tasks(Request $request)
    {
        $data = $this->demand->allTasks($request);
        return $this->successWithData($data);
    }

    /**
     * 获取需求列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $data = $this->demand->getDemandList($request);
        return $this->successWithData($data);
    }

    /**
     * 新建需求
     * @param DemandRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function store(DemandRequest $request)
    {
        $this->demand->createDemands($request);
        return $this->success();
    }

    /**
     * 更新demand 信息
     * @param DemandUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\DemandPermissionException
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function updateDemand(DemandUpdateRequest $request)
    {
        $this->demand->updateDemand($request);
        return $this->success();
    }

    /**
     * 关注或取消关注需求
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function attention(Request $request)
    {
        $this->demand->attention($request);
        return $this->success();
    }

    /**
     * 更改产品负责人
     * @param Request $request
     * @param Demand $demand
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPrincipal(Request $request, Demand $demand)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $this->demand->setPrincipal($demand, $data);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param Demand $demand
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipal(Request $request, Demand $demand)
    {
        $users = $this->teams->getTeamPrincipalByProducts($demand, TeamType::TYPE_PRODUCT);
        return $this->successWithData(compact('users'));
    }

    /**
     * @param DemandsExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(DemandsExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }

    /**
     * 需求转移
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transfer(Request $request)
    {
        $data = $request->validate([
            'demand_ids' => 'required|array',
            'demand_ids.*' => 'required|exists:pm_demands,id',
            'receiver_id' => 'required|exists:users,id',
        ], [], [
            'demand_ids' => '需求ID集合',
            'demand_ids.*' => '需求ID',
            'receiver_id' => '接收用户ID',
        ]);
        DB::beginTransaction();
        try {
            $this->demand->transfer($data);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }
}
