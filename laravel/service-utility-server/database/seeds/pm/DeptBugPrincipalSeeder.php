<?php

use App\Models\Department;
use App\Models\User;
use App\ProjectManage\Models\BugPrincipal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DeptBugPrincipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deptPrincipalCollection = collect($this->deptBugPrincipalData());

        // 获取基础部门
        $depts = Department::query()->where('is_base', 1)->get();
        foreach ($depts as $dept) {
            $principalData['dept_id'] = $dept->id;
            // 初始值
            $principalData['backend_program_user_id'] = 0;
            $principalData['backend_program_user_name'] = '';
            $principalData['backend_product_user_id'] = 0;
            $principalData['backend_product_user_name'] = '';
            $principalData['frontend_program_user_id'] = 0;
            $principalData['frontend_program_user_name'] = '';
            $principalData['frontend_product_user_id'] = 0;
            $principalData['frontend_product_user_name'] = '';
            $principalData['test_user_id'] = 0;
            $principalData['test_user_name'] = '';

            // 查找json中配置的负责人信息
            $principals = $deptPrincipalCollection->where('dept_name', $dept->name)->first();
            if ($principals) {
                $principalData = array_merge($principalData, $principals);
                unset($principalData['dept_name']);

                // 后台程序
                if (!empty($principals['backend_program_user_name'])) {
                    if ($backPrincipal = User::query()->where('name', $principals['backend_program_user_name'])->first()) {
                        $principalData['backend_program_user_id'] = $backPrincipal->id;
                    }
                }
                // 后台产品
                if (!empty($principals['backend_product_user_name'])) {
                    if ($backProduct = User::query()->where('name', $principals['backend_product_user_name'])->first()) {
                        $principalData['backend_product_user_id'] = $backProduct->id;
                    }
                }
                // 前台程序
                if (!empty($principals['frontend_program_user_name'])) {
                    if ($frontProgram = User::query()->where('name', $principals['frontend_program_user_name'])->first()) {
                        $principalData['frontend_program_user_id'] = $frontProgram->id;
                    }
                }
                // 前台产品
                if (!empty($principals['frontend_product_user_name'])) {
                    if ($frontProduct = User::query()->where('name', $principals['frontend_product_user_name'])->first()) {
                        $principalData['frontend_product_user_id'] = $frontProduct->id;
                    }
                }
                // 测试
                if (!empty($principals['test_user_name'])) {
                    if ($testUser = User::query()->where('name', $principals['test_user_name'])->first()) {
                        $principalData['test_user_id'] = $testUser->id;
                    }
                }
            }

            BugPrincipal::query()->updateOrCreate(['dept_id' => $dept->id], $principalData);
        }
    }

    /**
     * 部门负责人数据
     * @return array
     */
    protected function deptBugPrincipalData()
    {
        $bugDeptPrincipal = Storage::disk('data')->get('pm/bugDeptPrincipal.json');
        return json_decode($bugDeptPrincipal, true);
    }
}
