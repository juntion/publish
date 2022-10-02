<?php

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Department;
use \App\ProjectManage\Models\Product;
use \App\ProjectManage\Models\Team;
use \App\ProjectManage\Models\TeamMember;
use \App\ProjectManage\Models\Project;
use \App\ProjectManage\Models\Demand;
use \App\ProjectManage\Models\DemandLink;
use \App\ProjectManage\Models\Appeal;
use \App\ProjectManage\Models\DesignTask;
use \App\ProjectManage\Models\DesignPart;
use \App\ProjectManage\Models\DesignSubTask;
use \App\ProjectManage\Models\DevTask;
use \App\ProjectManage\Models\DevSubTask;
use \App\ProjectManage\Models\TestTask;
use \App\ProjectManage\Models\TestSubTask;

class ProjectManageDataSeeder extends Seeder
{
    /**
     * @author: King
     * @version: 2019/12/23 19:26
     */
    public function run()
    {
        // 临时禁用模型观察者
        Appeal::unsetEventDispatcher();
        Product::unsetEventDispatcher();

        if (empty(User::query()->first())){
            factory(User::class,10)->create();
        }
        if (empty(Department::query()->first())){
            $departments = factory(Department::class,5)->make();
            Department::query()->insert($departments->toArray());
        }

        // 产品线
        $lines = Product::query()->where('type',0)->get();
        if (!$lines->count()){
            factory(Product::class,10)->create();
            $lines = Product::query()->where('type',0)->get();
        }
        $lines->each(function (Product $item){
            $this->login();
            // 产品
            $product = $item->hasMany(Product::class,'parent_id')
                ->save(factory(Product::class)->state('type1')->make());
            // 模块
            $modules = $product->hasMany(Product::class,'parent_id')
                ->saveMany(factory(Product::class,5)->state('type2')->make());
            $modules->each(function (Product $item){
                // 负责人/团队
                $this->createTeam($item);
                // 模块分类
                $item->hasMany(Product::class,'parent_id')
                    ->saveMany(factory(Product::class,5)->state('type3')->make());
                // 项目
                $project = $this->createProject($item);
                $demand = $this->createDemand($project);
                $appeal = $this->createAppeal($project, $demand);
                $this->createDesignTask($demand, $project);
                $this->createDevTask($demand, $project);
                $this->createTestTask($demand, $project);
            });
            // 负责人/团队
            $this->createTeam($product);
        });
    }

    public function login()
    {
        auth()->login(User::first());
    }

    /**
     * 负责人/团队
     * @param $product
     * @author: King
     * @version: 2019/12/23 17:03
     */
    public function createTeam($product)
    {
        // 产品负责人
        $teams = $product->teams()->save(factory(Team::class)->state('type1')->make());
        $members = factory(TeamMember::class, 10)->state('type0')->make(['team_id' => $teams->id]);
        TeamMember::query()->insert($members->toArray());
        // 设计负责人
        $teams = $product->teams()->save(factory(Team::class)->state('type2')->make());
        $members = collect([
            factory(TeamMember::class)->state('type1')->make(['team_id' => $teams->id]),// 交互
            factory(TeamMember::class)->state('type2')->make(['team_id' => $teams->id]),// 视觉
            factory(TeamMember::class)->state('type3')->make(['team_id' => $teams->id]),// 前端
            factory(TeamMember::class)->state('type4')->make(['team_id' => $teams->id]),// 移动端
            factory(TeamMember::class)->state('type5')->make(['team_id' => $teams->id]),// 美工
        ]);
        TeamMember::query()->insert($members->toArray());

        // 开发负责人
        $product->teams()->save(factory(Team::class)->state('type3')->make());
        // 测试负责人
        $product->teams()->save(factory(Team::class)->state('type4')->make());
    }

    /**
     * 项目
     * @param $module
     * @return mixed
     * @author: King
     * @version: 2019/12/23 17:03
     */
    public function createProject($module)
    {
        $module->projects()->saveMany(factory(Project::class, 5)->states([
            'status' . rand(0,4),
            'level' . 'SABCD'[rand(0,4)],
            'difficulty' . rand(1,5),
        ])->make());
        return $module->projects()->save(factory(Project::class)->make());
    }

    /**
     * 诉求
     * @param $project
     * @param $demand
     * @return mixed
     * @author: King
     * @version: 2019/12/23 18:35
     */
    public function createAppeal($project, $demand)
    {
        factory(Appeal::class, 5)->state('status' . rand(0, 8))->create(['source_project_id' => $project->id]);
        $project->appeals()->saveMany(factory(Appeal::class, 2)->state('status0')->make())->each(function ($item){
            factory(Appeal::class)->create([
                'origin_id' => $item->id,
                'number' => $item->number . '-A',
            ]);
            factory(Appeal::class)->create([
                'origin_id' => $item->id,
                'number' => $item->number . '-B',
            ]);
        });
        return $project->appeals()->save(factory(Appeal::class)->state('status4')->make(['demand_id' => $demand->id]));
    }

    /**
     * 需求
     * @param $project
     * @return mixed
     * @author: King
     * @version: 2019/12/23 17:49
     */
    public function createDemand($project)
    {
        factory(Demand::class, 5)->states([
            'status' . rand(0,11),
            'priority' . rand(1,5)
        ])->create(['source_project_id' => $project->id]);
        $demand = $project->demands()->save(factory(Demand::class)->make());
        $demandLinks = collect([
            factory(DemandLink::class)->state('type1')->make(['demand_id' => $demand->id]),
            factory(DemandLink::class)->state('type2')->make(['demand_id' => $demand->id]),
            factory(DemandLink::class)->state('type3')->make(['demand_id' => $demand->id])
        ]);
        DemandLink::query()->insert($demandLinks->toArray());
        return $demand;
    }

    /**
     * 设计任务
     * @param $demand
     * @param $project
     * @author: King
     * @version: 2019/12/23 18:22
     */
    public function createDesignTask($demand, $project)
    {
        $designTask = $demand->designTasks()->save(factory(DesignTask::class)->make(['source_project_id' => $project->id]));
        $part = $designTask->parts()->save(factory(DesignPart::class)->make(['number' => $designTask->number . '-1']));
        factory(DesignSubTask::class)->states(['status0', 'is_main1'])->create([
            'task_id' => $designTask->id,
            'number' => $part->number . '-1',
            'part_id' => $part->id
        ]);
        factory(DesignSubTask::class)->states(['status0', 'is_main0'])->create([
            'task_id' => $designTask->id,
            'number' => $part->number . '-2',
            'part_id' => $part->id
        ]);
    }

    /**
     * 开发任务
     * @param $demand
     * @param $project
     * @author: King
     * @version: 2019/12/23 18:57
     */
    public function createDevTask($demand, $project)
    {
        $devTasks = $demand->devTasks()->save(factory(DevTask::class)->make(['source_project_id' => $project->id]));
        factory(DevSubTask::class)->states(['status0', 'is_main1'])->create([
            'task_id' => $devTasks->id,
            'number' => $devTasks->number . '-1'
        ]);
        factory(DevSubTask::class)->states(['status0', 'is_main0'])->create([
            'task_id' => $devTasks->id,
            'number' => $devTasks->number . '-2'
        ]);
    }

    /**
     * 测试任务
     * @param $demand
     * @param $project
     * @author: King
     * @version: 2019/12/23 19:02
     */
    public function createTestTask($demand, $project)
    {
        $testTasks = $demand->testTasks()->save(factory(TestTask::class)->make(['source_project_id' => $project->id]));
        factory(TestSubTask::class)->states(['status0', 'is_main1'])->create([
            'task_id' => $testTasks->id,
            'number' => $testTasks->number . '-1'
        ]);
        factory(TestSubTask::class)->states(['status0', 'is_main0'])->create([
            'task_id' => $testTasks->id,
            'number' => $testTasks->number . '-2'
        ]);
    }
}
