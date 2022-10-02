<?php

namespace App\Exports;

use App\ProjectManage\Repositories\Task\DevTaskListRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DevTaskExport implements WithTitle, WithEvents, WithColumnFormatting
{
    use Exportable, PMExportTrait;

    protected $headers = [
        '发布时间', '发布部门', '发布人', 'P级别', '需求等级', '产品类别', ' 需求号/需求标题', '总任务ID', '负责人', '子任务ID',
        '处理人', '预计交付时间', '完成情况', '子任务状态', '总任务状态',
    ];

    protected $data;
    protected $count = 0;

    public function __construct(DevTaskListRepository $devTaskList)
    {
        $this->data = $devTaskList->exportData();
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                $this->setCommonPart($workSheet, "O");

                // 正文部分
                foreach ($this->data as $devTask) {
                    $currentLine = $this->headLine() + $this->count + 1;
                    $workSheet->setCellValue('A' . $currentLine, Carbon::parse($devTask->created_at)->toDateString());
                    $workSheet->setCellValue('B' . $currentLine, $this->getBasicDept($devTask->promulgatorUser));
                    $workSheet->setCellValue('C' . $currentLine, $devTask->promulgator_name);
                    $workSheet->setCellValue('D' . $currentLine, $devTask->priority ?? '-');
                    $workSheet->setCellValue('E' . $currentLine, $this->getDemandLevel($devTask));
                    $workSheet->setCellValue('F' . $currentLine, $this->getProducts($devTask));
                    $workSheet->getStyle('F' . $currentLine)->getAlignment()->setWrapText(true);
                    $workSheet->setCellValue('G' . $currentLine, $this->getDemandInfo($devTask));
                    $workSheet->getStyle('G' . $currentLine)->getAlignment()->setWrapText(true);
                    $workSheet->setCellValue('H' . $currentLine, $devTask->number);
                    $workSheet->setCellValue('I' . $currentLine, $devTask->principal_user_name);
                    $workSheet->setCellValue('O' . $currentLine, $devTask->status_desc);

                    $devIndex = 0;
                    foreach ($devTask->subTasks as $devSubTask) {
                        $workSheet->setCellValue('J' . ($currentLine + $devIndex), $devSubTask->number);
                        $workSheet->setCellValue('K' . ($currentLine + $devIndex), $devSubTask->handler_name ?? '-');
                        $workSheet->setCellValue('L' . ($currentLine + $devIndex), $devSubTask->expiration_date ?? '-');
                        $workSheet->setCellValue('M' . ($currentLine + $devIndex), $this->getFinishDesc($devSubTask));
                        $workSheet->setCellValue('N' . ($currentLine + $devIndex), $devSubTask->status_desc);
                        $devIndex++;
                    }

                    $taskCount = $devTask->subTasks->count();
                    $this->count += max($taskCount, 1);

                    // 合并单元格
                    if (($mergeCell = $taskCount) > 1) {
                        $workSheet->mergeCells('A' . $currentLine . ':' . 'A' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('B' . $currentLine . ':' . 'B' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('C' . $currentLine . ':' . 'C' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('D' . $currentLine . ':' . 'D' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('E' . $currentLine . ':' . 'E' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('F' . $currentLine . ':' . 'F' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('G' . $currentLine . ':' . 'G' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('H' . $currentLine . ':' . 'H' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('I' . $currentLine . ':' . 'I' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('O' . $currentLine . ':' . 'O' . ($currentLine + $mergeCell - 1));
                    }
                }
            },

            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine(); $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(30);
                }
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':O' . $length)->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':O' . $length)->getFont()->setName('微软雅黑')->setSize(9);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':O' . $length)->applyFromArray($styleArray);

                // 列宽
                $workSheet->getColumnDimension('A')->setWidth(10);
                $workSheet->getColumnDimension('B')->setWidth(10);
                $workSheet->getColumnDimension('C')->setWidth(10);
                $workSheet->getColumnDimension('D')->setWidth(10);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(25);
                $workSheet->getColumnDimension('H')->setWidth(15);
                $workSheet->getColumnDimension('I')->setWidth(15);
                $workSheet->getColumnDimension('J')->setWidth(15);
                $workSheet->getColumnDimension('K')->setWidth(10);
                $workSheet->getColumnDimension('L')->setWidth(10);
                $workSheet->getColumnDimension('M')->setWidth(10);
                $workSheet->getColumnDimension('N')->setWidth(10);
                $workSheet->getColumnDimension('O')->setWidth(10);
            }
        ];
    }

    public function title(): string
    {
        return '任务信息统计表（开发环节）';
    }

    private function getDemandLevel($devTask)
    {
        if ($demand = $devTask->demand) {
            return $demand->level ?? '-';
        }
        return '-';
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
