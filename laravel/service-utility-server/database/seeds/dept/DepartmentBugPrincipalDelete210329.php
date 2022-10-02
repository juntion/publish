<?php

use App\ProjectManage\Models\BugPrincipal;
use Illuminate\Database\Seeder;

class DepartmentBugPrincipalDelete210329 extends Seeder
{
    /**
     * 2021-03-29
     * 已删除部门清除部门bug负责人配置数据
     *
     * @return void
     */
    public function run()
    {
        logSql();

        BugPrincipal::query()->whereDoesntHave('department')->delete();
    }
}
