<?php

use App\Models\Page;
use App\Models\Sidebar\SidebarCategory;
use App\Models\Sidebar\SidebarTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSidebarSeeder extends Seeder
{
    /**
     * 管理员侧边栏数据填充
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        if (empty($user)) {
            return;
        }
        $guardName = config('app.guard');

        // 创建管理员模板
        $templateData = [
            'name' => '管理员模板',
            'comment' => '管理员的侧边栏模板',
            'locale' => '{"en": "adminTemplate", "zh-CN": "管理员模板"}',
            'guard_name' => $guardName,
        ];
        // 防重
        if (SidebarTemplate::query()->where('name', $templateData['name'])->first()) {
            return;
        }
        $template = SidebarTemplate::create($templateData);
        // 关联模板
        $user->sidebarTemplates()->attach($template, ['guard_name' => $guardName]);

        // 栏目下的页面
        $sidebarPagesMap = [
            'user' => ['userInfoManage', 'userList'],
            'permission' => ['roleManage', 'permissionManage'],
            'sidebar' => ['templateManage', 'pageManage'],
            'subsystem' => ['subsystemManage',],
            'department' => ['departmentManage'],
            'position' => ['positionManage'],
        ];

        $categoriesData = [
            'user' => ['sidebar_template_id' => $template->id, 'name' => '用户管理', 'comment' => '用户管理', 'locale' => '{"en": "Users", "zh-CN": "用户管理"}', 'icon' => 'user'],
            'permission' => ['sidebar_template_id' => $template->id, 'name' => '角色与权限', 'comment' => '角色与权限', 'locale' => '{"en": "RoleAndPermission", "zh-CN": "角色与权限"}', 'icon' => 'lock'],
            'sidebar' => ['sidebar_template_id' => $template->id, 'name' => '侧边栏管理', 'comment' => '侧边栏管理', 'locale' => '{"en": "Sidebar", "zh-CN": "侧边栏管理"}', 'icon' => 'bars'],
            'subsystem' => ['sidebar_template_id' => $template->id, 'name' => '子系统管理', 'comment' => '子系统管理', 'locale' => '{"en": "Subsystem", "zh-CN": "子系统管理"}', 'icon' => 'folder'],
            'department' => ['sidebar_template_id' => $template->id, 'name' => '部门架构', 'comment' => '部门架构', 'locale' => '{"en": "Departments", "zh-CN": "部门架构管理"}', 'icon' => 'cluster'],
            'position' => ['sidebar_template_id' => $template->id, 'name' => '职称管理', 'comment' => '职称管理', 'locale' => '{"en": "Positions", "zh-CN": "职称管理"}', 'icon' => 'idcard'],
        ];

        foreach ($categoriesData as $key => $value) {
            $category = SidebarCategory::create($value);
            $pages = Page::where('guard_name', $guardName)->whereIn('route_name', $sidebarPagesMap[$key])->get();
            $category->pages()->attach($pages);
        }
    }
}
