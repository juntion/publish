<?php

namespace Modules\Tag\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Enums\TagDataStatus;
use Modules\Tag\Enums\TagDataType;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TagDataExport implements FromArray, WithTitle, WithEvents
{
    private $data;

    /**
     * 获取标签数据
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getData()
    {
        return TagData::query()->whereIn('uuid', request()->input('uuid', []))->with('parent')->get();
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $this->data = $this->getData();
        $result = [];
        $result[] = ['标签批量编辑'];
        $result[] = ['标签ID', '标签名称', '标签状态', '父级标签ID', '父级标签名称', '标签类型(产品/话题)', '标签URL名称(非必填)',
            '西语(es)', '法语(fr)', '俄语(ru)', '德语(de)', '日语(jp)', '意语(it)', '中文(cn)',];
        foreach ($this->data as $tag) {
            $locales = $tag->locale;
            $result[] = [
                $tag->number,
                $tag->name,
                TagDataStatus::getStatusDesc($tag->status),
                $tag->parent ? $tag->parent->number : '',
                $tag->parent ? $tag->parent->name : '',
                TagDataType::getTypeDesc($tag->type),
                $tag->url_name,
                $locales['es'] ?? '',
                $locales['fr'] ?? '',
                $locales['ru'] ?? '',
                $locales['de'] ?? '',
                $locales['jp'] ?? '',
                $locales['it'] ?? '',
                $locales['cn'] ?? '',
            ];
        }
        return $result;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return '标签批量编辑';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();

                $titleCell = 'A1:' . $this->lastColumn() . '1';
                $workSheet->mergeCells($titleCell);
                $workSheet->getRowDimension(1)->setRowHeight(30);
                $workSheet->getStyle($titleCell)->getAlignment()->setHorizontal('center')->setVertical('center');
                $workSheet->getStyle($titleCell)->getFont()->setBold(true)->setName('微软雅黑')->setSize(12);

                $headerCell = "A{$this->headerLine()}:{$this->lastColumn()}{$this->headerLine()}";
                $workSheet->getStyle($headerCell)->getAlignment()->setVertical('center');
                $workSheet->getStyle($headerCell)->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                $workSheet->getStyle($headerCell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('dce6f1');

                $count = count($this->data);
                $workSheet->getStyle('A3:D' . ($count + $this->headerLine()))->getAlignment()->setVertical('center');
                $workSheet->getStyle('A3:D' . ($count + $this->headerLine()))->getFont()->setName('微软雅黑')->setSize(9);

                $workSheet->getColumnDimension('A')->setWidth(10);
                $workSheet->getColumnDimension('B')->setWidth(20);
                $workSheet->getColumnDimension('C')->setWidth(10);
                $workSheet->getColumnDimension('D')->setWidth(15);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(20);
                $workSheet->getColumnDimension('H')->setWidth(20);
                $workSheet->getColumnDimension('I')->setWidth(20);
                $workSheet->getColumnDimension('J')->setWidth(20);
                $workSheet->getColumnDimension('K')->setWidth(20);
                $workSheet->getColumnDimension('L')->setWidth(20);
                $workSheet->getColumnDimension('M')->setWidth(20);
                $workSheet->getColumnDimension('N')->setWidth(20);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A2:' . $this->lastColumn() . ($count + $this->headerLine()))->applyFromArray($styleArray);
                $workSheet->getStyle('O2');
            },
        ];
    }

    private function headerLine(): int
    {
        return 2;
    }

    private function lastColumn(): string
    {
        return 'N';
    }
}
