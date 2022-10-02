<?php

namespace App\Exports\Permission;

use App\Models\Permission\Role;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class RolesExport implements WithTitle, WithEvents
{
    /**
     * 角色集合
     * @var \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private $roleData;

    private $count = 0;

    private $headers = ['角色', '子系统', '创建时间', '备注', '绑定人员', '主权限', '子权限'];

    public function __construct()
    {
        Validator::make(request()->all(), [
            'guard_name' => 'required|string',
        ])->validate();

        $this->roleData = $this->roleData();
    }

    /**
     * 角色数据
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function roleData()
    {
        $guard = request()->input('guard_name', config('app.guard'));
        $roles = Role::query()->where('guard_name', $guard)
            ->with(['subSystem', 'permissions', 'users' => function ($q) {
                $q->orderBy('name', 'asc');
            }])->get();
        $roles->each(function (Role $role) {
            $permissions = $role->permissions->groupBy('group')
                ->map(function ($item, $group) {
                    return ['name' => __($group), 'data' => $item];
                })->values();
            $permissionsCount = count($permissions);
            $this->count += ($permissionsCount > 0 ? $permissionsCount : 1);
            unset($role->permissions);
            $role->groupPermissions = $permissions;
        });
        return $roles;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                for ($i = 0, $iMax = count($this->headers); $i < $iMax; $i++) {
                    $workSheet->getCell(chr(65 + $i) . '1')->setValue($this->headers[$i]);
                }
                $workSheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center')->setVertical('center');
                $workSheet->getStyle('A1:G1')->getFont()->setBold(true)->setName('宋体')->setSize(11);
                $workSheet->getRowDimension(1)->setRowHeight(20);

                $currentLine = 2;
                foreach ($this->roleData as $role) {
                    $workSheet->setCellValue('A' . $currentLine, $role->name);
                    $workSheet->setCellValue('B' . $currentLine, $role->subSystem->name);
                    $workSheet->setCellValue('C' . $currentLine, $role->created_at->toDateTimeString());
                    $workSheet->setCellValue('D' . $currentLine, $role->comment);
                    // 绑定人员
                    $userNames = $role->users->pluck('name')->toArray();
                    $workSheet->setCellValue('E' . $currentLine, implode(PHP_EOL, $userNames));
                    $workSheet->getStyle('E' . $currentLine)->getAlignment()->setWrapText(true);
                    // 主权限
                    $permissionCount = count($role->groupPermissions);
                    $index = $currentLine;
                    if ($permissionCount > 0) {
                        foreach ($role->groupPermissions as $mainPermission) {
                            $workSheet->setCellValue('F' . $index, $mainPermission['name']);

                            $permissionNames = $mainPermission['data']->map(function ($item) {
                                return is_array($item['locale']) ? $item['locale']['zh-CN'] : json_decode($item['locale'], true)['zh-CN'];
                            })->values()->toArray();
                            $workSheet->setCellValue('G' . $index, implode(PHP_EOL, $permissionNames));
                            $workSheet->getStyle('G' . $index)->getAlignment()->setWrapText(true);

                            $index++;
                        }

                        $workSheet->mergeCells('A' . $currentLine . ':' . 'A' . ($index - 1));
                        $workSheet->mergeCells('B' . $currentLine . ':' . 'B' . ($index - 1));
                        $workSheet->mergeCells('C' . $currentLine . ':' . 'C' . ($index - 1));
                        $workSheet->mergeCells('D' . $currentLine . ':' . 'D' . ($index - 1));
                        $workSheet->mergeCells('E' . $currentLine . ':' . 'E' . ($index - 1));
                    } else {
                        // 对没有权限的用户
                        $index++;
                    }
                    $currentLine = $index;

                }
            },

            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                $workSheet->getStyle('A2:G' . ($this->count + 1))->getFont()->setName('宋体')->setSize(11);
                $workSheet->getStyle('A2:C' . ($this->count + 1))->getAlignment()->setHorizontal('center')->setVertical('center');
                $workSheet->getStyle('D2:D' . ($this->count + 1))->getAlignment()->setHorizontal('left')->setVertical('center')->setWrapText(true);
                $workSheet->getStyle('E2:G' . ($this->count + 1))->getAlignment()->setHorizontal('center')->setVertical('center');
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A1:G' . ($this->count + 1))->applyFromArray($styleArray);

                $workSheet->getColumnDimension('A')->setWidth(20);
                $workSheet->getColumnDimension('B')->setWidth(18);
                $workSheet->getColumnDimension('C')->setWidth(22);
                $workSheet->getColumnDimension('D')->setWidth(25);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(40);

                $workSheet->getStyle('H1');
            },
        ];
    }

    public function title(): string
    {
        return '角色信息表';
    }

    public function exportFileName(): string
    {
        return $this->title() . '_' . date('YmdHis') . '.xlsx';
    }
}
