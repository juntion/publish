<?php


namespace App\Http\Controllers\ProjectManage\Excel;


use App\Http\Controllers\Controller;
use App\ProjectManage\Repositories\ExcelRepository;
use \Illuminate\Http\Request;

class ExcelDownloadController extends Controller
{
    protected $excel;
    public function __construct(ExcelRepository $excelRepository)
    {
        parent::__construct();
        $this->excel = $excelRepository;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function assessmentAnalysis(Request $request)
    {
        if (!$request->has('start') || !$request->has('end')){
            throw new \Exception("时间范围不能为空");
        }
        return $this->excel->assessmentAnalysis($request);
    }
}
