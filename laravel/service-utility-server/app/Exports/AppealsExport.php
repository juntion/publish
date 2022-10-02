<?php

namespace App\Exports;

use App\Enums\ProjectManage\AppealType;
use App\Enums\ProjectManage\ProductStatus;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Repositories\AppealListRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AppealsExport implements FromArray, WithTitle, WithEvents
{
    use PMExportTrait;

    protected $appealList;

    protected $count;

    public function __construct(AppealListRepository $appealList)
    {
        $this->appealList = $appealList;
    }

    public function title(): string
    {
        return '诉求信息统计表';
    }

    public function array(): array
    {
        $result[] = ['诉求信息统计表'];
        if ($this->hasDateSearch()) {
            $date = explode(',', request()->input('search')['created_at']);
            $result[] = [
                '日期:',
                "自 {$date[0]} 至 {$date[1]}",
            ];
        }
        $result[] = [
            '发布时间', '发布部门', '发布人员', '发布类型', '紧急程度', '诉求ID及标题', '项目来源', '产品板块', '', '产品负责人',
            '产品跟进人', '跟进时间', '状态', '关联需求号',
        ];

        $appeals = $this->appealList->exportData();
        $this->count = $appeals->count();
        foreach ($appeals as $appeal) {
            $productLine = $appeal->products->where('type', ProductStatus::TypeLine)->first();
            $product = $appeal->products->where('type', ProductStatus::TypeProduct)->first();

            $result[] = [
                Carbon::parse($appeal->created_at)->toDateString(),
                $appeal->dept_name,
                $appeal->promulgator_name,
                AppealType::getTypeDesc($appeal->type),
                $this->urgentLevel($appeal),
                "SQ:{$appeal->number}" . PHP_EOL . "标题:{$appeal->name}",
                $this->projectSource($appeal),
                $productLine->name,
                $product->name,
                $appeal->principal_user_name,
                $appeal->follower_name ? $appeal->follower_name : '-',
                $appeal->follow_time ? Carbon::parse($appeal->follow_time)->toDateString() : '-',
                $appeal->status_desc,
                $appeal->demand ? $appeal->demand->number : '-',
            ];
        }

        return $result;
    }

    /**
     * 处理表格样式
     * @return array|\Closure[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                // 标题
                $workSheet->mergeCells('A1:N1');
                $workSheet->getRowDimension(1)->setRowHeight(50);
                $workSheet->getStyle('A1:N1')->getAlignment()->setHorizontal('center')->setVertical('center');
                $workSheet->getStyle('A1:N1')->getFont()->setBold(true)->setName('宋体')->setSize(18);
                // 日期
                if ($this->hasDateSearch()) {
                    $workSheet->getRowDimension(2)->setRowHeight(30);
                    $workSheet->mergeCells('B2:D2');
                    $workSheet->getStyle('A2:D2')->getAlignment()->setVertical('center');
                    $workSheet->getStyle('A2:D2')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                }
                // 表头
                $workSheet->mergeCells('H' . $this->headLine() . ':I' . $this->headLine());
                $workSheet->getStyle('H' . $this->headLine() . ':I' . $this->headLine())->getAlignment()->setHorizontal('center');
                $workSheet->getStyle('A' . $this->headLine() . ':N' . $this->headLine())->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . $this->headLine() . ':N' . $this->headLine())->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                // 正文
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine(); $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(30);
                }
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':N' . $length)->getAlignment()->setVertical('center');
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':N' . $length)->getFont()->setName('微软雅黑')->setSize(9);
                // 列宽
                $workSheet->getColumnDimension('A')->setWidth(10);
                $workSheet->getColumnDimension('B')->setWidth(10);
                $workSheet->getColumnDimension('C')->setWidth(10);
                $workSheet->getColumnDimension('D')->setWidth(10);
                $workSheet->getColumnDimension('E')->setWidth(10);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(20);
                $workSheet->getColumnDimension('H')->setWidth(20);
                $workSheet->getColumnDimension('I')->setWidth(20);
                $workSheet->getColumnDimension('J')->setWidth(10);
                $workSheet->getColumnDimension('K')->setWidth(10);
                $workSheet->getColumnDimension('L')->setWidth(10);
                $workSheet->getColumnDimension('M')->setWidth(10);
                $workSheet->getColumnDimension('N')->setWidth(20);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':N' . $length)->applyFromArray($styleArray);
                // 设置换行
                $workSheet->getStyle('F' . ($this->headLine() + 1) . ':G' . $length)->getAlignment()->setWrapText(true);
            }
        ];
    }

    /**
     * 紧急程度
     * @param Appeal $appeal
     * @return string
     */
    protected function urgentLevel(Appeal $appeal)
    {
        $res = '';
        if ($appeal->is_important)
            $res .= '重要';
        if ($appeal->is_urgent)
            $res .= '紧急';
        return $res ? $res : '-';
    }
}
