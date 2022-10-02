<?php

namespace Modules\Tag\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TagDataTemplateExport implements FromArray, WithEvents, WithTitle
{
    public function array(): array
    {
        $result = [];
        $result[] = ['标签批量上传模板下载'];
        // 标签名称默认是英语(en)
        // 多语言：英语(en) 西语(es) 法语(fr) 俄语(ru) 德语(de) 日语(jp) 意语(it) 中文(cn)
        $result[] = ['标签名称', '标签状态(开启/关闭)', '父级标签ID', '父级标签名称', '标签类型(产品/话题)', '标签URL名称(非必填)',
            '西语(es)', '法语(fr)', '俄语(ru)', '德语(de)', '日语(jp)', '意语(it)', '中文(cn)',];
        $result[] = ['A层级标签1', '开启', '', '', '产品', '指签名称对应的URL里展示的名称，非整个URL链接。举例：8023at-poe-switch',
            'Etiqueta de nivel A 1', 'Étiquette hiérarchique A 1', 'Уровень а уровень 1', 'Etikett A, ebene 1', 'aレベルラベル1', 'Marchi di categoria A 1', 'A层级标签1'];
        $result[] = ['B层级标签1', '开启', 1001, 'A层级标签1', '产品', ''];
        $result[] = ['C层级标签1', '关闭', 1002, 'B层级标签1', '话题', ''];
        return $result;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();

                $workSheet->mergeCells('A1:M1');
                $workSheet->getRowDimension(1)->setRowHeight(30);
                $workSheet->getStyle('A1:M1')->getAlignment()->setHorizontal('center')->setVertical('center');
                $workSheet->getStyle('A1:M1')->getFont()->setBold(true)->setName('微软雅黑')->setSize(12);

                $workSheet->getStyle('A2:M2')->getAlignment()->setVertical('center');
                $workSheet->getStyle('A2:M2')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                $workSheet->getStyle('A2:M2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('dce6f1');

                $workSheet->getStyle('A3:M6')->getAlignment()->setVertical('center');
                $workSheet->getStyle('A3:M6')->getFont()->setName('微软雅黑')->setSize(9);
                $workSheet->getStyle('F3')->getAlignment()->setWrapText(true);

                $workSheet->getColumnDimension('A')->setWidth(15);
                $workSheet->getColumnDimension('B')->setWidth(15);
                $workSheet->getColumnDimension('C')->setWidth(15);
                $workSheet->getColumnDimension('D')->setWidth(15);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(15);
                $workSheet->getColumnDimension('H')->setWidth(15);
                $workSheet->getColumnDimension('I')->setWidth(15);
                $workSheet->getColumnDimension('J')->setWidth(15);
                $workSheet->getColumnDimension('K')->setWidth(15);
                $workSheet->getColumnDimension('L')->setWidth(15);
                $workSheet->getColumnDimension('M')->setWidth(15);

                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A2:M6')->applyFromArray($styleArray);
                $workSheet->getStyle('N2');
            },
        ];
    }

    public function title(): string
    {
        return '标签批量上传模板';
    }
}
