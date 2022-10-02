<?php

namespace App\Exports;

use App\Enums\ProjectManage\DesignPartType;
use App\ProjectManage\Models\Project;
use App\ProjectManage\Models\ProjectPrincipals;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class ProjectExport implements WithTitle, WithEvents
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private $exportData;

    private const headers = [
        '项目编号', '项目名称', '创建人', '创建时间', '项目负责人', '项目描述', '指定负责人', '项目状态', '项目备注', '项目级别', '项目难度', '完成时间',
        '需求编号', '需求名称', '需求发布人', '产品负责人', '需求状态', '设计任务主负责人', '设计任务角色负责人', '设计跟进人',
        '开发主负责人', '开发实际负责人', '开发跟进人', '测试主负责人', '测试角色负责人', '测试跟进人',
    ];

    private $lastColumn = 'Z';

    private $count = 0;

    /**
     * ProjectExport constructor.
     */
    public function __construct()
    {
        $this->exportData = $this->getExportData();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getExportData()
    {
        return Project::query()->with(['projectPrincipals', 'demands.designTasks.parts.subTasks', 'demands.devTasks.subTasks', 'demands.testTasks.subTasks',])
            ->orderBy('id', 'desc')->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return '项目信息统计表';
    }

    /**
     * @return string
     */
    public function exportFileName(): string
    {
        return $this->title() . '_' . date('YmdHis') . '.xlsx';
    }

    /**
     * @return \Closure[]
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                // 标题
                for ($i = 0, $iMax = count(self::headers); $i < $iMax; $i++) {
                    $workSheet->getCell(chr(65 + $i) . $this->headLine())->setValue(self::headers[$i]);
                }
                $workSheet->getStyle('A' . $this->headLine() . ':' . $this->lastColumn . $this->headLine())->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . $this->headLine() . ':' . $this->lastColumn . $this->headLine())->getFont()->setBold(true)->setName('宋体')->setSize(12);

                // 正文
                $currentLine = $this->headLine() + 1;
                foreach ($this->getExportData() as $project) {
                    // 项目
                    $workSheet->setCellValue('A' . $currentLine, $project->number);
                    $workSheet->setCellValue('B' . $currentLine, $project->name);
                    $workSheet->setCellValue('C' . $currentLine, $project->promulgator_name);
                    $workSheet->setCellValue('D' . $currentLine, Carbon::parse($project->created_at)->toDateTimeString());
                    $workSheet->setCellValue('E' . $currentLine, $project->principal_user_name);
                    $workSheet->setCellValue('F' . $currentLine, strip_tags($project->contents));
                    $workSheet->setCellValue('G' . $currentLine, $this->projectPrncipals($project));
                    $workSheet->setCellValue('H' . $currentLine, $project->getStatus($project->status));
                    $workSheet->setCellValue('I' . $currentLine, $project->comment);
                    $workSheet->setCellValue('J' . $currentLine, $project->level);
                    $workSheet->setCellValue('K' . $currentLine, $project->difficulty);
                    $workSheet->setCellValue('L' . $currentLine, $project->finish_time);

                    // 需求
                    $demandIndex = 0;
                    if ($project->demands->isNotEmpty()) {
                        $projectStartLine = $currentLine;
                        foreach ($project->demands as $demand) {
                            $demandStartLine = $currentLine;
                            $workSheet->setCellValue('M' . ($currentLine + $demandIndex), $demand->number);
                            $workSheet->setCellValue('N' . ($currentLine + $demandIndex), $demand->name);
                            $workSheet->setCellValue('O' . ($currentLine + $demandIndex), $demand->promulgator_name);
                            $workSheet->setCellValue('P' . ($currentLine + $demandIndex), $demand->principal_user_name);
                            $workSheet->setCellValue('Q' . ($currentLine + $demandIndex), $demand->getStatus($demand->status));

                            // 开发任务
                            $devTaskIndex = 0;
                            foreach ($demand->devTasks as $devTask) {
                                $workSheet->setCellValue('U' . ($currentLine + $demandIndex + $devTaskIndex), $devTask->main_principal_user_name);
                                $workSheet->setCellValue('V' . ($currentLine + $demandIndex + $devTaskIndex), $devTask->principal_user_name);
                                $workSheet->setCellValue('W' . ($currentLine + $demandIndex + $devTaskIndex), implode(PHP_EOL, $devTask->subTasks()->pluck('handler_name')->toArray()));
                                $devTaskIndex++;
                            }
                            // 测试任务
                            $testTaskIndex = 0;
                            foreach ($demand->testTasks as $testTask) {
                                $workSheet->setCellValue('X' . ($currentLine + $demandIndex + $testTaskIndex), $testTask->main_principal_user_name);
                                $workSheet->setCellValue('Y' . ($currentLine + $demandIndex + $testTaskIndex), $testTask->principal_user_name);
                                $workSheet->setCellValue('Z' . ($currentLine + $demandIndex + $testTaskIndex), implode(PHP_EOL, $testTask->subTasks()->pluck('handler_name')->toArray()));
                                $testTaskIndex++;
                            }

                            // 设计任务
                            $designTaskIndex = 0;
                            foreach ($demand->designTasks as $designTask) {
                                $workSheet->setCellValue('R' . ($currentLine + $demandIndex + $designTaskIndex), $designTask->principal_user_name);

                                $designPartIndex = 0;
                                foreach ($designTask->parts as $designPart) {

                                    $workSheet->setCellValue('S' . ($currentLine + $demandIndex + $designTaskIndex + $designPartIndex),
                                        (DesignPartType::getDesc($designPart->type) . ': ' . $designPart->principal_user_name));
                                    $workSheet->setCellValue('T' . ($currentLine + $demandIndex + $designTaskIndex + $designPartIndex),
                                        implode(PHP_EOL, $designPart->subTasks()->pluck('handler_name')->toArray()));

                                    $designPartIndex++;
                                }

                                $designTaskIndex++;
                            }

                            $designPartCount = 0;
                            if ($designTask = $demand->designTasks->first()) {
                                $designPartCount = $designTask->parts->count();
                            }
                            $taskCount = max($designPartCount, 1);
                            $currentLine += $taskCount;

                            $workSheet->mergeCells('M' . $demandStartLine . ':M' . ($currentLine - 1));
                            $workSheet->mergeCells('N' . $demandStartLine . ':N' . ($currentLine - 1));
                            $workSheet->mergeCells('O' . $demandStartLine . ':O' . ($currentLine - 1));
                            $workSheet->mergeCells('P' . $demandStartLine . ':P' . ($currentLine - 1));
                            $workSheet->mergeCells('Q' . $demandStartLine . ':Q' . ($currentLine - 1));
                            $workSheet->mergeCells('R' . $demandStartLine . ':R' . ($currentLine - 1));
                            $workSheet->mergeCells('U' . $demandStartLine . ':U' . ($currentLine - 1));
                            $workSheet->mergeCells('V' . $demandStartLine . ':V' . ($currentLine - 1));
                            $workSheet->mergeCells('W' . $demandStartLine . ':W' . ($currentLine - 1));
                            $workSheet->mergeCells('X' . $demandStartLine . ':X' . ($currentLine - 1));
                            $workSheet->mergeCells('Y' . $demandStartLine . ':Y' . ($currentLine - 1));
                            $workSheet->mergeCells('Z' . $demandStartLine . ':Z' . ($currentLine - 1));
                            $workSheet->getStyle('M' . $demandStartLine . ':Z' . ($currentLine - 1))
                                ->getAlignment()->setVertical('center')->setWrapText(true);

                        }
                        // 合并项目单元格
                        $workSheet->mergeCells('A' . $projectStartLine . ':A' . ($currentLine - 1));
                        $workSheet->mergeCells('B' . $projectStartLine . ':B' . ($currentLine - 1));
                        $workSheet->mergeCells('C' . $projectStartLine . ':C' . ($currentLine - 1));
                        $workSheet->mergeCells('D' . $projectStartLine . ':D' . ($currentLine - 1));
                        $workSheet->mergeCells('E' . $projectStartLine . ':E' . ($currentLine - 1));
                        $workSheet->mergeCells('F' . $projectStartLine . ':F' . ($currentLine - 1));
                        $workSheet->mergeCells('G' . $projectStartLine . ':G' . ($currentLine - 1));
                        $workSheet->mergeCells('H' . $projectStartLine . ':H' . ($currentLine - 1));
                        $workSheet->mergeCells('I' . $projectStartLine . ':I' . ($currentLine - 1));
                        $workSheet->mergeCells('J' . $projectStartLine . ':J' . ($currentLine - 1));
                        $workSheet->mergeCells('K' . $projectStartLine . ':K' . ($currentLine - 1));
                        $workSheet->mergeCells('L' . $projectStartLine . ':L' . ($currentLine - 1));
                        $workSheet->getStyle('A' . $projectStartLine . ':L' . ($currentLine - 1))
                            ->getAlignment()->setVertical('center')->setWrapText(true);

                    } else {
                        $currentLine++;
                    }
                }
                $this->count = $currentLine - 1;
            },

            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':Z' . $this->count)->applyFromArray($styleArray);
                $workSheet->getStyle('A2:L' . $this->count)->getAlignment()->setVertical('center')->setWrapText(true);
                $workSheet->getStyle('A2' . ':Z' . $this->count)->getFont()->setName('宋体')->setSize(11);

                $workSheet->getColumnDimension('A')->setWidth(15);
                $workSheet->getColumnDimension('B')->setWidth(20);
                $workSheet->getColumnDimension('C')->setWidth(15);
                $workSheet->getColumnDimension('D')->setWidth(15);
                $workSheet->getColumnDimension('E')->setWidth(15);
                $workSheet->getColumnDimension('F')->setWidth(25);
                $workSheet->getColumnDimension('G')->setWidth(25);
                $workSheet->getColumnDimension('H')->setWidth(10);
                $workSheet->getColumnDimension('I')->setWidth(20);
                $workSheet->getColumnDimension('J')->setWidth(10);
                $workSheet->getColumnDimension('K')->setWidth(10);
                $workSheet->getColumnDimension('L')->setWidth(15);
                $workSheet->getColumnDimension('M')->setWidth(20);
                $workSheet->getColumnDimension('N')->setWidth(20);
                $workSheet->getColumnDimension('O')->setWidth(15);
                $workSheet->getColumnDimension('P')->setWidth(15);
                $workSheet->getColumnDimension('Q')->setWidth(10);
                $workSheet->getColumnDimension('R')->setWidth(15);
                $workSheet->getColumnDimension('S')->setWidth(20);
                $workSheet->getColumnDimension('T')->setWidth(15);
                $workSheet->getColumnDimension('U')->setWidth(15);
                $workSheet->getColumnDimension('V')->setWidth(15);
                $workSheet->getColumnDimension('W')->setWidth(20);
                $workSheet->getColumnDimension('X')->setWidth(15);
                $workSheet->getColumnDimension('Y')->setWidth(15);
                $workSheet->getColumnDimension('Z')->setWidth(20);

                $workSheet->getStyle('AA1');
            },
        ];
    }

    private function headLine()
    {
        return 1;
    }

    private function projectPrncipals(Project $project)
    {
        $res = '';
        $project->projectPrincipals->map(function (ProjectPrincipals $principal) use (&$res) {
            $res .= "{$principal->getTypeDesc()}: {$principal->user_name}({$principal->dept_name})" . PHP_EOL;
        });
        return $res;
    }

}
