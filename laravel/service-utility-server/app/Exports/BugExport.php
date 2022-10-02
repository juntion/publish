<?php

namespace App\Exports;

use App\Enums\ProjectManage\BugDataRestore;
use App\Enums\ProjectManage\OperationPlatform;
use App\ProjectManage\Models\Bug;
use App\ProjectManage\Repositories\BugsListRepository;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class BugExport implements FromArray, WithTitle, WithEvents
{
    use PMExportTrait, Exportable;

    protected $data;

    protected $count;

    protected $header = [
        '部门', '发布人', 'bug编号', 'CRM意见箱编号', '发布时间', '操作平台', '产品负责人', '开发负责人', '开发跟进人', '测试负责人',
        '处理时限', '原因类型', '根因分析', '数据修复请求', '数据修复说明', '解决方案', '调查进展', '标签', '状态',
    ];

    public function __construct(BugsListRepository $bugsListRepository)
    {
        $this->data = $bugsListRepository->exportData();
        $this->count = $this->data->count();
    }

    public function title(): string
    {
        return 'Bug信息统计表';
    }

    public function array(): array
    {
        $result[] = ['Bug信息表'];
        if ($this->hasDateSearch()) {
            $date = explode(',', request()->input('search')['created_at']);
            $result[] = [
                '日期:',
                "自 {$date[0]} 至 {$date[1]}",
            ];
        }
        $result[] = $this->header;

        foreach ($this->data as $bug) {
            $lineData = [
                $bug->dept_name,
                $bug->promulgator_name,
                $bug->number,
                $bug->erp_bug_number,
                $bug->created_at,
                OperationPlatform::getDesc($bug->operation_platform),
                $bug->product_principal_name,
                $bug->program_principal_name,
                $this->programHandlers($bug),
                $bug->test_principal_name,
                $this->getFinishDesc($bug) . PHP_EOL . $bug->expiration_date,
                $bug->reason ? $bug->reason->reason : '',
                $bug->reason_analyse ?? '',
                !empty($bug->data_restore) ? BugDataRestore::getDesc($bug->data_restore) : '',
                $bug->data_restore_comment ?? '',
                $bug->solution ?? '',
                $bug->inquiry_progress ?? '',
                $this->bugLabels($bug),
                $bug->status_desc,
            ];
            $result[] = $lineData;
        }


        return $result;
    }

    /**
     * 发布信息
     * @param Bug $bug
     * @return string
     */
    protected function publishInfo(Bug $bug)
    {
        return $bug->dept_name . PHP_EOL .
            $bug->number . PHP_EOL .
            $bug->promulgator_name . PHP_EOL .
            $bug->created_at;
    }

    protected function bugLabels(Bug $bug): string
    {
        $labels = $bug->labels->pluck('name')->toArray();
        if ($labels) {
            return implode(PHP_EOL, $labels);
        }
        return '';
    }

    /**
     * 处理人
     * @param Bug $bug
     * @return string
     */
    protected function programHandlers(Bug $bug)
    {
        $names = $bug->handlers->pluck('handler_name')->toArray();
        if (empty($names)) {
            return '';
        }
        return implode(PHP_EOL, $names);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                // 标题
                $workSheet->mergeCells('A1:S1');
                $workSheet->getRowDimension(1)->setRowHeight(50);
                $workSheet->getStyle('A1:S1')->getAlignment()->setHorizontal('center')->setVertical('center');
                $workSheet->getStyle('A1:S1')->getFont()->setBold(true)->setName('宋体')->setSize(18);
                // 日期
                if ($this->hasDateSearch()) {
                    $workSheet->getRowDimension(2)->setRowHeight(30);
                    $workSheet->mergeCells('B2:D2');
                    $workSheet->getStyle('A2:D2')->getAlignment()->setVertical('center');
                    $workSheet->getStyle('A2:D2')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                }
                // 表头
                $workSheet->getStyle('A' . $this->headLine() . ':S' . $this->headLine())->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . $this->headLine() . ':S' . $this->headLine())->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                $workSheet->getRowDimension($this->headLine())->setRowHeight(30);

                // 正文
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine() + 1; $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(55);
                }
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':S' . $length)->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':S' . $length)->getFont()->setName('微软雅黑')->setSize(9);
                // 列宽
                $workSheet->getColumnDimension('A')->setWidth(15);
                $workSheet->getColumnDimension('B')->setWidth(15);
                $workSheet->getColumnDimension('C')->setWidth(20);
                $workSheet->getColumnDimension('D')->setWidth(15);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(15);
                $workSheet->getColumnDimension('H')->setWidth(15);
                $workSheet->getColumnDimension('I')->setWidth(15);
                $workSheet->getColumnDimension('J')->setWidth(15);
                $workSheet->getColumnDimension('K')->setWidth(15);
                $workSheet->getColumnDimension('L')->setWidth(20);
                $workSheet->getColumnDimension('M')->setWidth(20);
                $workSheet->getColumnDimension('N')->setWidth(20);
                $workSheet->getColumnDimension('O')->setWidth(20);
                $workSheet->getColumnDimension('P')->setWidth(20);
                $workSheet->getColumnDimension('Q')->setWidth(20);
                $workSheet->getColumnDimension('R')->setWidth(15);
                $workSheet->getColumnDimension('S')->setWidth(15);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':S' . $length)->applyFromArray($styleArray);
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':S' . $length)->getAlignment()->setWrapText(true);
                $workSheet->getStyle('T1');
            }
        ];
    }
}
