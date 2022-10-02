<?php


namespace App\Http\Controllers\ProjectManage\Project;


use App\Exceptions\Project\InvaildParameterException;
use App\Exports\ProjectExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Requests\Project\ProjectStatusRequest;
use App\Http\Requests\Project\ProjectSummaryRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\ProjectManage\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    protected $project;
    public function __construct(ProjectRepository $projectRepository)
    {
        parent::__construct();
        $this->project = $projectRepository;
    }

    /**
     * 关注或取消关注项目
     * @return \Illuminate\Http\JsonResponse
     * @throws InvaildParameterException
     */
    public function attention()
    {
        $this->project->attention();
        return $this->success();
    }

    /**
     * 返回项目的具体信息
     * @return \Illuminate\Http\JsonResponse
     * @throws InvaildParameterException
     */
    public function details()
    {
        $data = $this->project->details();
        return $this->successWithData($data);
    }

    /**
     * 项目列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->project->index();
        return $this->successWithData($data);
    }

    /**
     * 用户被提醒的动态
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDynamicLog()
    {
        $data = $this->project->getDynamicLog();
        return $this->successWithData($data);
    }

    /**
     * 返回具体项目的日志信息
     * @return \Illuminate\Http\JsonResponse
     * @throws InvaildParameterException
     */
    public function getProjectLogs()
    {
        $data = $this->project->getProjectLogs();
        return $this->successWithData($data);
    }

    /**
     * 重点项目
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvaildParameterException
     */
    public function createMajorProject(ProjectRequest $request)
    {
        $this->project->createProject($request);
        return $this->success();
    }

    /**
     * 日常项目
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvaildParameterException
     */
    public function createDailyProject(ProjectRequest $request)
    {
        $this->project->createProject($request, 0);
        return $this->success();
    }

    /**
     * 更新项目
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvaildParameterException
     * @throws \App\Exceptions\Project\ProjectPermissionException
     */
    public function updateProject(ProjectUpdateRequest $request)
    {
        $this->project->updateProject($request);
        return $this->success();
    }


    /*
     * 移除文件
     */
    public function deleteMedia()
    {
        $this->project->deleteMedia();
        return $this->success();
    }

    /**
     * 更新状态
     * @param ProjectStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvaildParameterException
     * @throws \App\Exceptions\Project\ProjectPermissionException
     */
    public function updateStatus(ProjectStatusRequest $request)
    {
        $this->project->updateStatus($request);
        return $this->success();
    }

    /**
     * 获取相关统计
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics(Request $request)
    {
        $data = $this->project->statistics();
        return $this->successWithData($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Project\ProjectPermissionException
     */
    public function projectSummary(ProjectSummaryRequest $request)
    {
        $this->project->projectSummary($request);
        return $this->success();
    }

    /**
     * @param ProjectExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(ProjectExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }
}
