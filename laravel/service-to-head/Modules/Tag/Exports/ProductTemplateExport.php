<?php

namespace Modules\Tag\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Tag\Enums\TagDataSourceModelType;

class ProductTemplateExport implements FromArray, WithTitle, WithEvents
{
    private $dataSourceTypeName;

    public function __construct()
    {
        $bindingType = request()->input('binding_type', 1);
        $this->dataSourceTypeName = TagDataSourceModelType::getModelTypeCNName($bindingType);
    }

    public function array(): array
    {
        $result[] = [
            '绑定标签ID',
            '绑定标签名称',
            $this->dataSourceTypeName . 'ID',
            $this->dataSourceTypeName . '名称',
            $this->dataSourceTypeName . '排序',
        ];
        $result[] = [1000, 'A层级标签1', 10001, '名称1', 1];
        $result[] = [1001, 'B层级标签1', 10002, '名称2', 2];
        $result[] = [1002, 'C层级标签1', 10003, '名称3', 3];
        return $result;
    }

    public function title(): string
    {
        return $this->dataSourceTypeName . '批量上传模板';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();

                $workSheet->getStyle('A1:E1')->getAlignment()->setVertical('center');
                $workSheet->getStyle('A1:E1')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);

                $workSheet->getStyle('A2:E5')->getAlignment()->setVertical('center');
                $workSheet->getStyle('A2:E5')->getFont()->setName('微软雅黑')->setSize(9);

                $workSheet->getColumnDimension('A')->setWidth(15);
                $workSheet->getColumnDimension('B')->setWidth(15);
                $workSheet->getColumnDimension('C')->setWidth(15);
                $workSheet->getColumnDimension('D')->setWidth(20);
                $workSheet->getColumnDimension('E')->setWidth(15);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A1:E5')->applyFromArray($styleArray);
                $workSheet->getStyle('F1');
            },
        ];
    }
}
