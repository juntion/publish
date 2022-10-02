<?php

namespace App\Exports;

use App\Models\Department;
use App\Repositories\Department\DepartmentRepository;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepartmentExport implements WithTitle, WithEvents
{
    use Exportable;

    protected $deptData;
    protected $deptUsers;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->deptData = $departmentRepository->tree();
        $this->deptUsers = Department::query()->with('users')->get();
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                $workSheet->setCellValue('A1', '基础部门');
                $workSheet->setCellValue('B1', '部门');

                foreach ($this->deptData as $dept) {
                    $this->fillCell($workSheet, $dept);
                }
            },
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();

                $workSheet->getStyle('A1:B1')->getAlignment()->setVertical('center');
                $workSheet->getStyle('A1:B1')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);

                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A1:' . chr(65 + $this->maxLevel + 2) . ($this->index - 1))->applyFromArray($styleArray);

                // 列宽
                $workSheet->getColumnDimension('A')->setWidth(10);
                for ($i = 0; $i <= ($this->maxLevel + 1); $i++) {
                    $workSheet->getColumnDimension(chr(66 + $i))->setWidth(16);
                }
            }
        ];
    }

    protected $index = 2;
    protected $maxLevel = 0;

    protected function fillCell(Worksheet $workSheet, $dept)
    {
        $columnIndex = 66; // B
        $workSheet->setCellValue("A" . $this->index, $this->isBaseDept($dept));
        $workSheet->setCellValue(chr($columnIndex + $this->deptLevel($dept)) . $this->index, $dept['name']);
        $this->index++;

        if (!empty($dept['children'])) {
            foreach ($dept['children'] as $item) {
                $this->fillCell($workSheet, $item);
            }
        }

        // 部门成员
        $deptUsers = $this->deptUsers->where('id', $dept['id'])->first();
        $deptUsers = $deptUsers->users;
        foreach ($deptUsers as $user) {
            $workSheet->setCellValue(chr($columnIndex + $this->deptLevel($dept) + 1) . $this->index, $user->name);
            $this->index++;
        }
    }

    /**
     * @param $dept
     * @return string
     */
    protected function isBaseDept($dept)
    {
        return $dept['is_base'] == 1 ? '是' : '否';
    }

    /**
     * 部门层级
     * @param $dept
     * @return int
     */
    protected function deptLevel($dept)
    {
        $res = explode('-', $dept['path']);
        $res = collect($res)->filter()->toArray();
        $level = count($res);
        if ($level > $this->maxLevel) {
            $this->maxLevel = $level;
        }
        return $level;
    }

    public function title(): string
    {
        return '部门组织架构';
    }
}
