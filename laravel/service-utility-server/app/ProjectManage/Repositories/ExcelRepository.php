<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\AppealStatus;
use App\Enums\ProjectManage\DemandStatus;
use App\Exports\AnalysisAssessmentExport;
use App\Models\Department;
use App\Models\User;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Demand;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelRepository
{
    protected $start;     // 开始时间
    protected $end;       // 结束时间
    protected $info;      // 格式化需要的info
    protected $data;      // 总的数据
    protected $dataCount; // 单个用户的数据条数

    protected $levelPoint = [
        "S" => 8,
        "A" => 8,
        "B" => 5,
        "C" => 5,
        "D" => 1
    ]; // 等级分数

    protected $typePoint = [
        "promulgator" => 2,
        "principal"   => 3,
    ]; // 类型分数

    protected $statusPoint = [
        "complete_S" => 8,
        "complete_A" => 8,
        "complete_B" => 5,
        "complete_C" => 5,
        "complete_D" => 1,
        "others"   => "0",
    ]; // 状态分数

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function assessmentAnalysis(Request $request)
    {
        if($request->has('user_ids')){
            $ids = $request->input('user_ids');
            $user_ids = User::query()->whereIn('id', $ids)->get()->pluck('id', 'name')->toArray();
        } else {
            $departments = $this->getDepartments();
            $department_ids = array_keys($departments);
            $user_ids = [];
            Department::query()->whereIn('id', $department_ids)->get()->map(function ($item)use (&$user_ids){
                $user_ids = collect($user_ids)->merge($item->users->pluck('id','name'))->toArray();
            });
        }
        $this->start = $request->input('start');
        $this->end = $request->input('end');
        return $this->exportExcel($user_ids, $request);
    }

    /**
     * 获取部门信息
     * @return mixed
     */
    protected function getDepartments()
    {
        $ids[212] = "系统分析部";
        $this->getChildDepartment(212, $ids);
        return $ids;
    }

    /**
     * 系统分析部的所有子部门
     * @param $id
     * @param $ids
     * @return mixed
     */
    protected function getChildDepartment($id, &$ids)
    {
        Department::query()
            ->where('parent_id', $id)
            ->select('id','name')
            ->get()->map(function ($item)use (&$ids){
                $ids[$item->id] = $item->name;
                if ($item->children){
                    $this->getChildDepartment($item->id, $ids);
                }
            });
        return $ids;
    }


    /**
     * 单个卡片的数据
     * @param array $user
     */
    protected function getFormatData(array $user)
    {
        $this->getDataHeader($user['name']);
        $this->getUserData($user['id']);
        $this->getDataFooter();
    }

    /**
     * 循环获取用户数据
     * @param $users
     */
    protected function getExportData($users)
    {
        foreach ($users as $k=>$v){
            $user = [
                'name' => $k,
                'id'   => $v
            ];
            $this->getFormatData($user);
        }
    }

    /**
     * 获取单个用户的数据
     * @param $id
     */
    protected function getUserData($id)
    {
        if ($this->info){
            $info = $this->info;
            $start = end($info)['end'] + 4;
        } else {
            $start = 5;
        }
        $this->formatUserData($id, $start);
    }

    /**
     * 格式化用户数据
     * @param $id
     * @param $start
     */
    protected function formatUserData($id, $start)
    {
        $data = [];
        if ($this->data){
            $data = $this->data;
        }
        $userData = [];
        $demands = Demand::query()->whereNotIn('status', [DemandStatus::STATUS_REVOCATION, DemandStatus::STATUS_PAUSED])
            ->where(function ($q)use($id){
                $q->where('promulgator_id', $id)->orWhere("principal_user_id", $id);
            })
            ->whereRaw("created_at <= '" .$this->end . " 23:59:59'")
            ->whereRaw("if(`status` = " . DemandStatus::STATUS_COMPLETED . ", finish_time >= '". $this->start . " 00:00:00'". ", 1=1)")
            ->with("project")
            ->get()->map(function ($item)use(&$userData, $id){
                $logs = $item->statusLogs->where('new_status',$item->status)->last();
                $level = $item->project && $item->project->level ? strtoupper($item->project->level) : "D";
                $project = "--";
                if ($item->project){
                    $project = $item->project->number . "\n" . $item->project->principal_user_name . "\n" . $item->project->level;
                }
                $userData[] = [
                    'number'      => $item->number,
                    'name'        => $item->name,
                    'created_at'  => $item->created_at,
                    'level'       => $level,
                    'work_type'   => $id == $item->principal_user_id ? "principal" : "promulgator",
                    'status'      => $item->getStatus($item->status),
                    'status_time' => $logs ? $logs->created_at: "",
                    'status_type' => ($item->status == DemandStatus::STATUS_COMPLETED && strtotime($item->finish_time) <= strtotime($this->end . " 23:59:59")) ? ('complete_' . $level) : 'others',
                    'project'     => $project
                ];
            });
        $Appeals = Appeal::query()->where("status",AppealStatus::STATUS_COMPLETED)
            ->where("demand_id",0)
            ->where(function ($q)use($id){
                $q->where('follower_id', $id)->orWhere("principal_user_id", $id);
            })
            ->where("created_at", "<=", $this->end . " 23:59:59")
            ->whereBetween('finish_time',[$this->start . " 00:00:00", $this->end . " 23:59:59"])
            ->with("project")
            ->get()->map(function ($item)use(&$userData, $id){
                $level = $item->project && $item->project->level ? strtoupper($item->project->level) : "D";
                $project = "--";
                if ($item->project){
                    $project = $item->project->number . "\n" . $item->project->principal_user_name . "\n" . $item->project->level;
                }
                $userData[] = [
                    'number'      => $item->number,
                    'name'        => $item->name,
                    'created_at'  => $item->created_at,
                    'level'       => $level,
                    'work_type'   => $id == $item->principal_user_id ? "principal" : "promulgator",
                    'status'      => $item->getStatus($item->status),
                    'status_time' => $item->finish_time,
                    'status_type' => "complete_" . $level,
                    'project'     => $project
                ];
            });

        $count = count($userData);
        $i = 0;
        collect($userData)->sortByDesc('created_at')->map(function ($item)use(&$data,$count,&$i,$start){
            $line = $start + $i;
            $data [] = [
                $i+1,
                $item['number'] . "\n" . $item['name'],
                $item['created_at'],
                $item['project'],
                ($this->levelPoint)[$item['level']],
                ($this->typePoint)[$item['work_type']],
                ($this->statusPoint)[$item['status_type']],
                $item['status'] . "\n" . $item['status_time'],
                "=SUM(E{$line}:G{$line})"
            ];
            $i++;
        });
        $this->dataCount = $count;
        $this->data = $data;
    }

    /**
     * 每个用户的卡片的header
     * @param string $userName
     */
    protected function getDataHeader(string $userName)
    {
        $data = [];
        if ($this->data){
            $data = $this->data;
        }
        $data[] = ["名字:", $userName, "部门:", "系统分析部"];
        $data[] = ["周期:", $this->start . "至" . $this->end];
        $data[] = ["序号", "项目名称(需求/诉求）", "发布时间","关联项目信息\n（编号/负责人/S级）","项目等级\n战略（8）重点（5）常规（1）", "工作方式\n负责（3）执行（2）", "完成进度\n完成（8/5/1）未完成（0）", "当前状态/时间", "合计"];
        $this->data = $data;
    }

    /**
     * 卡片的footer
     */
    protected function getDataFooter()
    {
        $data = [];
        if ($this->data){
            $data = $this->data;
        }
        $info = [];
        if ($this->info){
            $info = $this->info;
            $start = end($info)['end'] + 1;
        } else {
            $start = 2;
        }
        $first_index = $start + 3;
        $last_index = $start + $this->dataCount + 2;
        $new = [
            'start' => $start,
            'end'   => $start + $this->dataCount + 4,
        ];
        $info[] = $new;
        $this->info = $info;
        if ($this->dataCount == 0){
            $footer = ['合计',"","","","0","0",'0',"","0"];
        } else {
            $footer = [
                '合计',
                "",
                "",
                "",
                "=SUM(E{$first_index}:E{$last_index})",
                "=SUM(F{$first_index}:F{$last_index})",
                "=SUM(G{$first_index}:G{$last_index})",
                "",
                "=SUM(I{$first_index}:I{$last_index})"
            ];
        }
        $data[] = $footer;
        $data[] = [" "]; // 新建一个空白行
        $this->data = $data;
    }

    /**
     * 导出excel
     * @param array $users
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    protected function exportExcel(array $users, Request $request)
    {
        $fileName = "";
        if (count($users) == 1){
            $fileName = array_keys($users)[0];
        } else {
            $fileName .= "系统分析部";
        }
        $fileName .= " 考核统计模板(" . $request->input('start') . "-" . $request->input('end') .").xlsx";
        try{
            $this->getExportData($users);
            return Excel::download((new AnalysisAssessmentExport())->setData($this->data, $this->info), $fileName);
        }catch (\Exception $exception){
            \Log::info("导出信息错误：". $exception);
            throw new \Exception($exception->getMessage());
        }
    }
}
