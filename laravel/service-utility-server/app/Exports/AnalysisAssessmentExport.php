<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AnalysisAssessmentExport implements FromArray, WithTitle, WithHeadings, WithEvents
{

    protected $start = 1;
    protected $end;
    protected $infoArr;
    protected $data;
    public function array(): array
    {
        $data = $this->data;
        $this->end = count($data) + 2;
        return $data;
    }

    public function setData(array $data, array $info)
    {
        $this->data = $data;
        $this->infoArr = $info;
        return $this;
    }

    public function title(): string
    {
        return "系统分析部考核表";
    }

    public function headings(): array
    {
        return  ["考核统计表"];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class  => function(AfterSheet $event){
                // 表头
                $cellRange = 'A1:I1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(16)->setBold(true);
                $event->sheet->getDelegate()->mergeCells($cellRange);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(35); // title行高34
                // $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(30); // 批量设置行高未生效？？
                for ($i=2; $i<=$this->end; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(53);
                }
                // 设置宽度
                $event->sheet->getDelegate()->getDefaultColumnDimension()->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension("D")->setWidth(35);
                $event->sheet->getDelegate()->getColumnDimension("E")->setWidth(35);
                // 自动换行及居中
                $event->sheet->getDelegate()->getStyle("A1:I".$this->end)->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                // 处理每一个人的卡片
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ]
                    ],
                    'font' => [
                        'size' => 12
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER, // 水平居中
                        'wrapText'   => true
                    ],
                    'fill' => [
                        'fillType'  => Fill::FILL_PATTERN_GRAY0625
                    ]
                ];
                foreach ($this->infoArr as $key=>$item){
                    if ($key == 0 || $key % 2 == 0){
                        $styleArray['fill']['color']= ['argb'=> "FFFCE4D6"] ;
                    } else {
                        $styleArray['fill']['color'] = ['argb'=>"FFC4E0FB"];
                    }
                    $start = $item['start'];
                    $end = $item['end'];
                    $endLine = $end - 1;
                    $event->sheet->getDelegate()->getStyle("A{$start}:I". ($start+2))->getFont()->setBold(true);
                    $event->sheet->getDelegate()->getStyle("A{$start}:I". ($end-1))->applyFromArray($styleArray);
                    // 合并单元格
                    $event->sheet->getDelegate()->mergeCells("E{$start}:I{$start}");
                    $event->sheet->getDelegate()->mergeCells("C" . ($start+1) .":I". ($start+1));
                    $event->sheet->getDelegate()->mergeCells("A{$end}:B{$end}");
                    $event->sheet->getDelegate()->getStyle("A{$endLine}:I{$endLine}")->getFont()->setBold(true)->setColor(new Color(Color::COLOR_RED));
                    $event->sheet->getDelegate()->getStyle("I{$start}:I{$end}")->getFont()->setBold(true);
                }
            }
        ];
    }
}
