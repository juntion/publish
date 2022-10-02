<?php

namespace App\Exports;

use App\Enums\ProjectManage\DesignPartType;
use App\ProjectManage\Repositories\Task\DesignTaskListRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class DesignTaskExport implements WithEvents, WithTitle, WithColumnFormatting
{
    use Exportable, PMExportTrait;

    protected $headers = [
        '发布时间', '发布部门', '发布人', 'P级别', '产品类别', ' 需求号/需求标题', '总任务ID', '设计总负责人', '子任务ID', '设计类型/角色负责人',
        '处理人', '预计交付时间', '完成情况', '子任务状态', '总任务状态',
    ];

    protected $data;
    protected $count = 0;

    public function __construct(DesignTaskListRepository $designTaskList)
    {
        $this->data = $designTaskList->exportData();
    }

    public function title(): string
    {
        return '任务信息统计表（设计环节）';
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                $this->setCommonPart($workSheet, 'O');

                // 正文
                foreach ($this->data as $designTask) {
                    $currentLine = $this->headLine() + $this->count + 1;
                    $workSheet->setCellValue('A' . $currentLine, Carbon::parse($designTask->created_at)->toDateString());
                    $workSheet->setCellValue('B' . $currentLine, $this->getBasicDept($designTask->promulgatorUser));
                    $workSheet->setCellValue('C' . $currentLine, $designTask->promulgator_name);
                    $workSheet->setCellValue('D' . $currentLine, $designTask->priority ?? '-');
                    $workSheet->setCellValue('E' . $currentLine, $this->getProducts($designTask));
                    $workSheet->getStyle('E' . $currentLine)->getAlignment()->setWrapText(true);
                    $workSheet->setCellValue('F' . $currentLine, $this->getDemandInfo($designTask));
                    $workSheet->getStyle('F' . $currentLine)->getAlignment()->setWrapText(true);
                    $workSheet->setCellValue('G' . $currentLine, $designTask->number);
                    $workSheet->setCellValue('H' . $currentLine, $designTask->principal_user_name);
                    $workSheet->setCellValue('O' . $currentLine, $designTask->status_desc);
                    // 设计环节
                    $designIndex = 0;
                    foreach ($designTask->parts as $designPart) {
                        $designPartInfo = $this->designPartInfo($designPart);
                        $workSheet->setCellValue('I' . ($currentLine + $designIndex), $designPart->number);
                        $workSheet->setCellValue('J' . ($currentLine + $designIndex), $designPartInfo['principal']);
                        $workSheet->setCellValue('K' . ($currentLine + $designIndex), $designPartInfo['handler']);
                        $workSheet->setCellValue('L' . ($currentLine + $designIndex), $designPartInfo['expirationDate']);
                        $workSheet->setCellValue('M' . ($currentLine + $designIndex), $designPartInfo['finishDesc']);
                        $workSheet->setCellValue('N' . ($currentLine + $designIndex), $designPartInfo['status']);
                        $designIndex++;
                    }

                    $partCount = $designTask->parts->count();
                    $this->count += max($partCount, 1);

                    // 合并单元格
                    if (($mergeCell = $partCount) > 1) {
                        $workSheet->mergeCells('A' . $currentLine . ':' . 'A' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('B' . $currentLine . ':' . 'B' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('C' . $currentLine . ':' . 'C' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('D' . $currentLine . ':' . 'D' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('E' . $currentLine . ':' . 'E' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('F' . $currentLine . ':' . 'F' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('G' . $currentLine . ':' . 'G' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('H' . $currentLine . ':' . 'H' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('O' . $currentLine . ':' . 'O' . ($currentLine + $mergeCell - 1));
                    }
                }
            },

            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
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
                $workSheet->getColumnDimension('E')->setWidth(10);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(15);
                $workSheet->getColumnDimension('H')->setWidth(10);
                $workSheet->getColumnDimension('I')->setWidth(15);
                $workSheet->getColumnDimension('J')->setWidth(20);
                $workSheet->getColumnDimension('K')->setWidth(20);
                $workSheet->getColumnDimension('L')->setWidth(10);
                $workSheet->getColumnDimension('M')->setWidth(10);
                $workSheet->getColumnDimension('N')->setWidth(10);
                $workSheet->getColumnDimension('O')->setWidth(10);
            },
        ];
    }

    private function designPartInfo($designPart): array
    {
        $type = DesignPartType::getDesc($designPart->type);
        $res['principal'] = "{$type}({$designPart->principal_user_name})";
        $subTask = $designPart->subTasks->first();
        $res['handler'] = $subTask ? "{$type}({$subTask->handler_name})" : '-';
        $res['expirationDate'] = ($subTask && $subTask->expiration_date) ? $subTask->expiration_date : '-';
        $res['status'] = $subTask ? $subTask->status_desc : '-';
        $res['finishDesc'] = $this->getFinishDesc($subTask);
        return $res;
    }

    public function columnFormats(): array
    {
        return [
            'G' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT
        ];
    }
}
