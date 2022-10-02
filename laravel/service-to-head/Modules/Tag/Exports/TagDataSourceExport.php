<?php

namespace Modules\Tag\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Tag\Entities\TagDataSource;
use Modules\Tag\Enums\TagDataSourceModelType;

class TagDataSourceExport implements FromArray, WithTitle, WithEvents
{
    private $data;

    private $dataSourceTypeName;

    public function __construct()
    {
        $bindingType = request()->input('binding_type', 1);
        $this->dataSourceTypeName = TagDataSourceModelType::getModelTypeCNName($bindingType);
    }

    private function getData()
    {
        $uuid = request()->input('uuid');
        $this->data = TagDataSource::query()->whereIn('uuid', $uuid)->with('tag')->get();
    }

    public function array(): array
    {
        $this->getData();

        $result[] = [
            'uuid', '标签ID', '标签名称', "{$this->dataSourceTypeName}ID", "{$this->dataSourceTypeName}名称", '排序',
        ];
        foreach ($this->data as $item) {
            $result[] = [
                $item->uuid,
                $item->tag->number,
                $item->tag->name,
                $item->model_id,
                $item->model_desc,
                $item->priority,
            ];
        }
        return $result;
    }

    public function title(): string
    {
        return '绑定批量编辑';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();

                $workSheet->getStyle('A1:F1')->getAlignment()->setVertical('center');
                $workSheet->getStyle('A1:F1')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);

                $count = count($this->data);
                $lastCell = 'F' . ($count + 1);
                $workSheet->getStyle('A2:' . $lastCell)->getAlignment()->setVertical('center');
                $workSheet->getStyle('A2:' . $lastCell)->getFont()->setName('微软雅黑')->setSize(9);

                $workSheet->getColumnDimension('A')->setWidth(20);
                $workSheet->getColumnDimension('B')->setWidth(15);
                $workSheet->getColumnDimension('C')->setWidth(20);
                $workSheet->getColumnDimension('D')->setWidth(15);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(10);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A1:' . $lastCell)->applyFromArray($styleArray);
                $workSheet->getStyle('G1');

            },
        ];
    }
}
