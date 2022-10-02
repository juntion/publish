<?php


namespace App\Http\Controllers\ProjectManage\Project;


use App\Http\Controllers\Controller;
use App\Http\Requests\Project\DemandBatchConfirmRequest;
use App\ProjectManage\Models\Demand;
use App\ProjectManage\Repositories\DemandRepository;
use Illuminate\Http\Request;

class DemandsController extends Controller
{
    protected $demand;
    public function __construct(DemandRepository $demand)
    {
        parent::__construct();
        $this->demand = $demand;
    }

    /**
     * 确认需求
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\DemandPermissionException
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function confirmDemand()
    {
        $this->demand->confirm();
        return $this->success();
    }

    /**
     * 批量确认需求
     * @param DemandBatchConfirmRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchConfirm(DemandBatchConfirmRequest $request)
    {
        $this->demand->batchConfirm($request);
        return $this->success();
    }

    /**
     * 推送项目
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\DemandPermissionException
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function pushDemand(Request $request)
    {
        $this->demand->pushDemand($request);
        return $this->success();
    }

    /**
     * 批量推送
     * @param DemandBatchConfirmRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function batchPushDemand(DemandBatchConfirmRequest $request)
    {
        $this->demand->batchPushDemand($request);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\DemandPermissionException
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function cancelConfirm()
    {
        $this->demand->cancelConfirm();
        return $this->success();
    }
}
