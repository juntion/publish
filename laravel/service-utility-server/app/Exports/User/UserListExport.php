<?php

namespace App\Exports\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Exceptions\Rpc\RpcException;
use App\Exports\PMExportTrait;
use App\Models\Department;
use App\Repositories\User\UserRepository;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UserListExport implements FromArray, WithTitle, WithEvents
{
    use PMExportTrait;

    // 用户数据
    private $userData;

    // 管理员等级集合
    private $adminLevels;

    private $departments;

    private $count = 0;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->adminLevels = collect($this->getAdminLevels());
        $this->userData = $this->getUserData();
        $this->departments = Department::query()->get();
    }

    /**
     * @return \App\Support\QueryBuilder\QueryBuilder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getUserData()
    {
        $userData = $this->userRepository->exportData();
        foreach ($userData as $user) {
            $adminLevel = $this->adminLevels->where('profile_id', $user->admin_level)->first();
            $user->admin_level_desc = $adminLevel ? $adminLevel['profile_name'] : '';
        }
        $this->count = count($userData);
        return $userData;
    }

    /**
     * 获取管理员等级
     * @return mixed
     * @throws RpcException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getAdminLevels()
    {
        $userRpc = app()->make(UserRpcInterface::class);
        $res = $userRpc->adminLevel();
        if ($res['status'] == 'success') {
            return $res['data'];
        }
        throw new RpcException('获取管理员等级失败！');
    }

    public function array(): array
    {
        $result = [];
        $result[] = [$this->tableTitle()];
        $result[] = ['说明: 1.复核人员为各部门IT对接人，根据所属部门复核部门下所有账号；2.导表时间为 ' . date('Y/m/d H:i:s')];
        $result[] = [
            '用户名', '邮箱', '邮箱验证时间', '所属一级部门', '所属二级部门', '所属三级部门', '职位', '岗位', '管理员等级', '所属子公司', '更新时间',
            '账户有效性' . PHP_EOL . '(填写 "是/否")', '复核结果' . PHP_EOL . '(填写 "保留/删除/修改")', '原因备注' . PHP_EOL . '(删除/修改在此填写)', '复核人签字',
        ];
        foreach ($this->userData as $user) {
            $allDept = collect();
            if ($defaultDept = $user->department->first()) {
                $allDept = $this->departments->whereIn('id', array_merge($defaultDept->parentIds, [$defaultDept->id]));
                $allDept = $allDept->map(function ($dept) {
                    $dept->level = count($dept->parentIds);
                    return $dept->toArray();
                });
            }
            $topDept = $allDept->where('level', 0)->first();
            $secondDept = $allDept->where('level', 1)->first();
            $thirdDept = $allDept->where('level', 2)->first();
            $result[] = [
                $user->name,
                $user->email,
                $user->email_verified_at ?? '',
                $topDept ? $topDept['name'] : '',
                $secondDept ? $secondDept['name'] : '',
                $thirdDept ? $thirdDept['name'] : '',
                implode(',', $user->positions->pluck('name')->toArray()),
                implode(',', $user->posts->pluck('name')->toArray()),
                $user->admin_level_desc,
                $user->company ? $user->company->company_name : '',
                $user->updated_at,
            ];
        }
        return $result;
    }

    public function title(): string
    {
        return '后台账户管理详情表';
    }

    public function tableTitle(): string
    {
        $dateStr = '';
        if ($date = request()->input('search.updated_date')) {
            $dateStr = PHP_EOL . '导出时间范围: ' . str_replace(',', '~', $date);
        }
        return $this->title() . $dateStr;
    }

    protected function headLine()
    {
        return 3;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                // 标题
                $workSheet->mergeCells('A1:O1');
                $workSheet->getRowDimension(1)->setRowHeight(42);
                $workSheet->getStyle('A1:O1')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
                $workSheet->getStyle('A1:O1')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
                // 说明
                $workSheet->mergeCells('A2:F2');
                $workSheet->getStyle('A2')->getFont()->setColor(new Color(Color::COLOR_RED))->setName('微软雅黑')->setSize(9);
                $workSheet->getRowDimension(2)->setRowHeight(15);
                // 表头
                $workSheet->getRowDimension($this->headLine())->setRowHeight(30);
                $workSheet->getStyle('A' . $this->headLine() . ':O' . $this->headLine())->getFont()->setName('微软雅黑')->setSize(10);
                $workSheet->getStyle('A' . $this->headLine() . ':K' . $this->headLine())->getAlignment()->setVertical('center');
                $workSheet->getStyle('L' . $this->headLine() . ':O' . $this->headLine())
                    ->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
                // 设置表头背景色
                $workSheet->getStyle('A' . $this->headLine() . ':K' . $this->headLine())->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('dce6f1');
                $workSheet->getStyle('L' . $this->headLine() . ':O' . $this->headLine())->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff9900');
                // 正文
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine() + 1; $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(15);
                }
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':O' . $length)->getFont()->setName('微软雅黑')->setSize(9);
                //列宽
                $workSheet->getColumnDimension('A')->setWidth(15);
                $workSheet->getColumnDimension('B')->setWidth(20);
                $workSheet->getColumnDimension('C')->setWidth(15);
                $workSheet->getColumnDimension('D')->setWidth(15);
                $workSheet->getColumnDimension('E')->setWidth(20);
                $workSheet->getColumnDimension('F')->setWidth(20);
                $workSheet->getColumnDimension('G')->setWidth(20);
                $workSheet->getColumnDimension('H')->setWidth(15);
                $workSheet->getColumnDimension('I')->setWidth(15);
                $workSheet->getColumnDimension('J')->setWidth(40);
                $workSheet->getColumnDimension('K')->setWidth(20);
                $workSheet->getColumnDimension('L')->setWidth(20);
                $workSheet->getColumnDimension('M')->setWidth(25);
                $workSheet->getColumnDimension('N')->setWidth(30);
                $workSheet->getColumnDimension('O')->setWidth(20);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':O' . $length)->applyFromArray($styleArray);
                $workSheet->getStyle('P1');
            },
        ];
    }
}
