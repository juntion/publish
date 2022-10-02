<?php

namespace App\Exports;

use App\ProjectManage\Repositories\Releases\ReleaseVersionRepository;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ReleaseVersionFeatureExport implements FromArray, WithTitle, WithEvents
{
    protected $featureList;
    private $count;

    public function __construct(ReleaseVersionRepository $releaseVersionRepository)
    {
        $releaseVersion = request()->route('releaseVersion');
        $this->featureList = $releaseVersionRepository->getVersionFeatures($releaseVersion, false);
        $this->count = $this->featureList->count();
    }

    public function array(): array
    {
        $result = [];
        $result[] = [
            '任务ID', '功能描述(任务标题)', '任务状态', '处理人', '产品需求信息', '诉求人', '测试人员', '分支名', 'SQL', '压测', '版本号/状态', '产品确认',
        ];
        foreach ($this->featureList as $subTask) {
            $result[] = [
                $subTask['number'],
                $this->featureDesc($subTask),
                $subTask['status_desc'],
                $subTask['handler_name'],
                $this->demandProduct($subTask),
                implode(PHP_EOL, $subTask['appeal_users']), //诉求人
                implode(PHP_EOL, $subTask['test_handlers']), // 测试人员
                $subTask['branch_name'],
                $subTask['has_sql'] == 0 ? '无' : '有',
                $subTask['stress_test'] == 0 ? '-' : '压测',
                $this->versionInfo($subTask),
                $subTask['product_confirmed'] == 0 ? '未确认' : '已确认',
            ];
        }
        return $result;
    }

    public function title(): string
    {
        return '功能清单';
    }

    /**
     * 导出文件名
     * @return string
     */
    public function exportFileName(): string
    {
        return $this->title() . '_' . date('YmdHis') . '.xlsx';
    }

    private function featureDesc($subTask): string
    {
        if (isset($subTask['demand'])) {
            return $subTask['demand']->name;
        }
        return $subTask['task_title'];
    }

    private function demandProduct($subTask): string
    {
        if (isset($subTask['demand'])) {
            return $subTask['demand']->number . PHP_EOL . $subTask['demand']->promulgator_name;
        }
        return '';
    }

    private function versionInfo($subTask): string
    {
        return $subTask['version']->full_version . PHP_EOL . $subTask['version']->status_desc;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                // 表头
                $workSheet->getStyle('A' . $this->headLine() . ':L' . $this->headLine())->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . $this->headLine() . ':L' . $this->headLine())->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                // 正文
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine(); $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(30);
                }
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':L' . $length)->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':L' . $length)->getFont()->setName('微软雅黑')->setSize(9);
                // 列宽
                $workSheet->getColumnDimension('A')->setWidth(15);
                $workSheet->getColumnDimension('B')->setWidth(30);
                $workSheet->getColumnDimension('C')->setWidth(10);
                $workSheet->getColumnDimension('D')->setWidth(15);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(20);
                $workSheet->getColumnDimension('H')->setWidth(20);
                $workSheet->getColumnDimension('I')->setWidth(10);
                $workSheet->getColumnDimension('J')->setWidth(10);
                $workSheet->getColumnDimension('K')->setWidth(20);
                $workSheet->getColumnDimension('L')->setWidth(10);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':L' . $length)->applyFromArray($styleArray);
                // 设置换行
                $workSheet->getStyle('B' . ($this->headLine() + 1) . ':B' . $length)->getAlignment()->setWrapText(true);
                $workSheet->getStyle('E' . ($this->headLine() + 1) . ':G' . $length)->getAlignment()->setWrapText(true);
                $workSheet->getStyle('K' . ($this->headLine() + 1) . ':K' . $length)->getAlignment()->setWrapText(true);
                $workSheet->getStyle('M1');
            },
        ];
    }

    private function headLine()
    {
        return 1;
    }
}
