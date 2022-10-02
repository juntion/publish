<?php

namespace App\Exports;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DesignPartType;
use App\Enums\ProjectManage\ProductStatus;
use App\ProjectManage\Repositories\DemandRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class DemandsExport implements WithTitle, WithEvents
{
    use Exportable, PMExportTrait;

    protected $headers = [
        '发布时间', '发布部门', '发布人', 'P级别', '产品类别', '产品负责人', '项目来源', '需求号及标题', '设计总负责人', '角色/负责人',
        '角色/跟进人', '设计状态', '开发负责人', '开发跟进人', '开发状态', '测试负责人', '测试跟进人', '测试状态', 'task', '需求状态', '关联诉求号',
    ];

    protected $data;
    protected $count = 0;

    public function __construct(DemandRepository $demandRepository)
    {
        $this->data = $demandRepository->exportData();
    }

    public function title(): string
    {
        return '需求信息统计表';
    }

    public function registerEvents(): array
    {
        return [
            // 数据填充
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                $this->setCommonPart($workSheet, 'U');

                // 正文
                foreach ($this->data as $demand) {
                    $currentLine = $this->headLine() + $this->count + 1;
                    $workSheet->setCellValue('A' . $currentLine, Carbon::parse($demand->created_at)->toDateString());
                    $workSheet->setCellValue('B' . $currentLine, $this->getBasicDept($demand->promulgatorUser));
                    $workSheet->setCellValue('C' . $currentLine, $demand->promulgator_name);
                    $workSheet->setCellValue('D' . $currentLine, $demand->priority ?? '-');
                    $workSheet->setCellValue('E' . $currentLine, $this->getProducts($demand));
                    $workSheet->getStyle('E' . $currentLine)->getAlignment()->setWrapText(true);
                    $workSheet->setCellValue('F' . $currentLine, $demand->principal_user_name);
                    $workSheet->setCellValue('G' . $currentLine, $this->projectSource($demand));
                    $workSheet->getStyle('G' . $currentLine)->getAlignment()->setWrapText(true);
                    $workSheet->setCellValue('H' . $currentLine, "XQ:{$demand->number}" . PHP_EOL . "标题:{$demand->name}");
                    $workSheet->getStyle('H' . $currentLine)->getAlignment()->setWrapText(true);
                    //设计环节
                    $designLink = $demand->demandLinks->where('type', DemandLinksType::TYPE_DESIGN)->first();
                    $workSheet->setCellValue('I' . $currentLine, $designLink ? $designLink->principal_user_name : '-');

                    // 设计负责人
                    $designIndex = 0;
                    foreach ($demand->designPart as $designPart) {
                        $resDesign = $this->designPrincipal($designPart);
                        $workSheet->setCellValue('J' . ($currentLine + $designIndex), $resDesign[0]);
                        $workSheet->setCellValue('K' . ($currentLine + $designIndex), $resDesign[1]);
                        $workSheet->setCellValue('L' . ($currentLine + $designIndex), $designPart->status_desc);
                        $designIndex++;
                    }

                    // 开发环节
                    $devLink = $demand->demandLinks->where('type', DemandLinksType::TYPE_DEVELOP)->first();
                    $workSheet->setCellValue('M' . $currentLine, $devLink ? $devLink->principal_user_name : '-');
                    $devIndex = 0;
                    if ($devTask = $demand->devTasks->first()) {
                        foreach ($devTask->subTasks as $devSubTask) {
                            $workSheet->setCellValue('N' . ($currentLine + $devIndex), $devSubTask->handler_name ?? '-');
                            $workSheet->setCellValue('O' . ($currentLine + $devIndex), $devSubTask->status_desc);
                        }
                    }
                    // 测试环节
                    $testLink = $demand->demandLinks->where('type', DemandLinksType::TYPE_DEVELOP)->first();
                    $workSheet->setCellValue('P' . $currentLine, $testLink ? $testLink->principal_user_name : '-');
                    if ($testTask = $demand->testTasks->first()) {
                        $testSubTask = $testTask->subTasks->first();
                        $workSheet->setCellValue('Q' . $currentLine, $testSubTask ? $testSubTask->handler_name : '-');
                        $workSheet->setCellValue('R' . $currentLine, $testTask ? $testTask->status_desc : '-');
                    }
                    // task num
                    $workSheet->setCellValue('S' . $currentLine, $this->getTaskNum($demand));
                    $workSheet->setCellValue('T' . $currentLine, $demand->status_desc);
                    $workSheet->setCellValue('U' . $currentLine, $this->getAppeals($demand));
                    $workSheet->getStyle('U' . $currentLine)->getAlignment()->setWrapText(true);

                    // 处理 count 增加
                    $designTaskCount = $demand->designPart->count();
                    $devTaskCount = $demand->devSubtasks->count();
                    $this->count += max($designTaskCount, $devTaskCount, 1);

                    // 合并单元格
                    if ($mergeCell = max($designTaskCount, $devTaskCount)) {
                        $workSheet->mergeCells('A' . $currentLine . ':' . 'A' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('B' . $currentLine . ':' . 'B' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('C' . $currentLine . ':' . 'C' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('D' . $currentLine . ':' . 'D' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('E' . $currentLine . ':' . 'E' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('F' . $currentLine . ':' . 'F' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('G' . $currentLine . ':' . 'G' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('H' . $currentLine . ':' . 'H' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('I' . $currentLine . ':' . 'I' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('M' . $currentLine . ':' . 'M' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('P' . $currentLine . ':' . 'P' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('Q' . $currentLine . ':' . 'Q' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('R' . $currentLine . ':' . 'R' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('S' . $currentLine . ':' . 'S' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('T' . $currentLine . ':' . 'T' . ($currentLine + $mergeCell - 1));
                        $workSheet->mergeCells('U' . $currentLine . ':' . 'U' . ($currentLine + $mergeCell - 1));
                    }
                }

            },

            // 样式调整
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine(); $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(30);
                }
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':U' . $length)->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':U' . $length)->getFont()->setName('微软雅黑')->setSize(9);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':U' . $length)->applyFromArray($styleArray);

                // 列宽
                $workSheet->getColumnDimension('A')->setWidth(10);
                $workSheet->getColumnDimension('B')->setWidth(10);
                $workSheet->getColumnDimension('C')->setWidth(10);
                $workSheet->getColumnDimension('D')->setWidth(10);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(10);
                $workSheet->getColumnDimension('G')->setWidth(20);
                $workSheet->getColumnDimension('H')->setWidth(20);
                $workSheet->getColumnDimension('I')->setWidth(10);
                $workSheet->getColumnDimension('J')->setWidth(20);
                $workSheet->getColumnDimension('K')->setWidth(20);
                $workSheet->getColumnDimension('L')->setWidth(10);
                $workSheet->getColumnDimension('M')->setWidth(10);
                $workSheet->getColumnDimension('N')->setWidth(10);
                $workSheet->getColumnDimension('O')->setWidth(10);
                $workSheet->getColumnDimension('P')->setWidth(10);
                $workSheet->getColumnDimension('Q')->setWidth(10);
                $workSheet->getColumnDimension('R')->setWidth(10);
                $workSheet->getColumnDimension('S')->setWidth(10);
                $workSheet->getColumnDimension('T')->setWidth(10);
                $workSheet->getColumnDimension('U')->setWidth(20);
            }
        ];
    }

    /**
     * @param $demand
     * @return string
     */
    private function getProducts($demand): string
    {
        $products = $demand->products->whereIn('type', [ProductStatus::TypeLine, ProductStatus::TypeProduct]);
        return implode(PHP_EOL, $products->pluck('name')->toArray());
    }

    /**
     * @param $designPart
     * @return mixed
     */
    private function designPrincipal($designPart)
    {
        $type = DesignPartType::getDesc($designPart->type);
        $res[] = "{$type}({$designPart->principal_user_name})";
        $subTask = $designPart->subTasks->first();
        $res[] = $subTask ? "{$type}({$subTask->handler_name})" : '-';
        return $res;
    }

    /**
     * 任务数量
     * @param $demand
     * @return int
     */
    protected function getTaskNum($demand)
    {
        $count = 0;
        if ($demand->designPart->isEmpty() && $demand->designTasks->isNotEmpty()) {
            $count = 1;
        }
        $demand->designPart->map(function ($item) use (&$count) {
            $num = count($item->subTasks->toArray());
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        $demand->devTasks->map(function ($item) use (&$count) {
            $num = count($item->subTasks->toArray());
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        $demand->testTasks->map(function ($item) use (&$count) {
            $num = count($item->subTasks->toArray());
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        return $count;
    }

    /**
     * 关联诉求号
     * @param $demand
     * @return string
     */
    private function getAppeals($demand)
    {
        $appeals = $demand->appeals->pluck('number')->toArray();
        if ($appeals) {
            return implode(PHP_EOL, $appeals);
        }
        return '-';
    }
}
