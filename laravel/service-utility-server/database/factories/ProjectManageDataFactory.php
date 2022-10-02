<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProjectManage\Models\Label;
use App\ProjectManage\Models\LabelCategory;
use Faker\Generator as Faker;
use \Illuminate\Support\Carbon;
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

if (!function_exists('setState')) {
    function setState(\Illuminate\Database\Eloquent\Factory $factory, array $array, $class, $state)
    {
        foreach ($array as $item) {
            $factory->state($class, $state . $item, [$state => $item]);
        }
    }
}

if (!function_exists('userAndDept')) {
    function userAndDept(Faker $faker)
    {
        $users = User::query()->pluck('id')->toArray();
        $departments = Department::query()->pluck('id')->toArray();
        $user = User::query()->find($faker->randomElement($users));
        $dept = Department::query()->find($faker->randomElement($departments));
        return [$user, $dept];
    }
}

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'status' => 1,
        'description' => $faker->text(),
        'type' => 0,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});
setState($factory, [0, 1, 2, 3], Product::class, 'type');

$factory->define(Team::class, function (Faker $faker) {
    [$user, $dept] = userAndDept($faker);
    return [
        'user_id' => $user->id,
        'user_name' => $user->name,
        'dept_id' => $dept->id,
        'dept_name' => $dept->name,
        'type' => 1,
        'is_default' => 1,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});
setState($factory, [1, 2, 3, 4], Team::class, 'type');

$factory->define(TeamMember::class, function (Faker $faker) {
    [$user, $dept] = userAndDept($faker);
    return [
        'user_id' => $user->id,
        'user_name' => $user->name,
        'dept_id' => $dept->id,
        'dept_name' => $dept->name,
        'type' => 0,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5], TeamMember::class, 'type');

$factory->define(Project::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('\PHisu');
    return [
        'number' => $number,
        'name' => $faker->text(20),
        'type' => 1,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'expiration_date' => $faker->date(),
        'contents' => $faker->text(3000),
        'status' => 1,
        'shared_address' => ["\\10.1.1.59\共享\设计\个人共享\视觉设计\Rose孙正\10.25研发工作管理系统"],
        'promulgator_id' => $user->id,
        'promulgator_name' => $user->name,
        'comment' => $faker->text(),
        'level' => 'S',
        'difficulty' => 5,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});
setState($factory, [0, 1, 2, 3, 4], Project::class, 'status');
setState($factory, ['S', 'A', 'B', 'C', 'D'], Project::class, 'level');
setState($factory, [1, 2, 3, 4, 5], Project::class, 'difficulty');

$factory->define(Demand::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('\DHisu');
    return [
        'priority' => 1,
        'number' => $number,
        'name' => $faker->text(20),
        'content' => $faker->text(3000),
        'source_project_name' => $faker->text(20),
        'expiration_date' => $faker->date(),
        'status' => 3,
        'share_address' => ["\\10.1.1.59\共享\设计\个人共享\视觉设计\Rose孙正\10.25研发工作管理系统"],
        'promulgator_id' => $user->id,
        'promulgator_name' => $user->name,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'verify_user_id' => $user->id,
        'verify_user_name' => $user->name,
        'verify_time' => $faker->dateTime(),
        'confirmed' => 1,
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], Demand::class, 'status');
setState($factory, [1, 2, 3, 4, 5], Demand::class, 'priority');

$factory->define(Appeal::class, function (Faker $faker) {
    [$user, $dept] = userAndDept($faker);
    $number = Carbon::now()->format('\AHisu');
    return [
        'number' => $number,
        'name' => $faker->text(20),
        'content' => $faker->text(3000),
        'brief' => $faker->text(),
        'type' => 1,
        'is_urgent' => 1,
        'is_important' => 1,
        'source_project_name' => $faker->text(20),
        'expiration_date' => $faker->date(),
        'status' => 4,
        'dept_id' => $dept->id,
        'dept_name' => $dept->name,
        'promulgator_id' => $user->id,
        'promulgator_name' => $user->name,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'follower_id' => $user->id,
        'follower_name' => $user->name,
        'follow_time' => $faker->dateTime(),
        'follow_type' => 0,
        'verify_user_id' => $user->id,
        'verify_user_name' => $user->name,
        'verify_time' => $faker->dateTime(),
        'comment' => $faker->text(),
        'origin_id' => 0,
        'demand_id' => 0,
        'questions' => '{"urgent":[{"question":"紧急的问题","answer":"紧急的问题答案"}],"important":[{"question":"重要的问题","answer":"重要的问题答案"}]}',
        'crux' => $faker->text(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5, 6, 7, 8], Appeal::class, 'status');

$factory->define(DemandLink::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    return [
        'type' => 1,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'comment' => $faker->text(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [1, 2, 3], DemandLink::class, 'type');

$factory->define(DesignTask::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('10su');
    return [
        'number' => $number,
        'source_project_id' => 0,
        'promulgator_id' => $user->id,
        'promulgator_name' => $user->name,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'priority' => 1,
        'expiration_date' => $faker->date(),
        'content' => $faker->text(3000),
        'status' => 3,
        'review' => 1,
        'review_result' => 1,
        'review_comment' => $faker->text(),
        'review_time' => $faker->dateTime(),
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'design_type' => 1,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5, 6, 7, 8], DesignTask::class, 'status');
setState($factory, [1, 2, 3, 4, 5], DesignTask::class, 'priority');

$factory->define(DesignPart::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('10isu');
    return [
        'number' => $number,
        'type' => 3,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'status' => 2,
        'stage' => 1,
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5, 6, 7], DesignPart::class, 'status');
setState($factory, [0, 1, 2, 3, 4], DesignPart::class, 'type');

$factory->define(DesignSubTask::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('10Hisu');
    return [
        'number' => $number,
        'task_id' => 0,
        'priority' => 5,
        'expiration_date' => $faker->dateTime(),
        'description' => $faker->text(),
        'handler_id' => $user->id,
        'handler_name' => $user->name,
        'share_address' => ["\\10.1.1.59\共享\设计\个人共享\视觉设计\Rose孙正\10.25研发工作管理系统"],
        'status' => 0,
        'is_main' => 1,
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5], DesignSubTask::class, 'status');
setState($factory, [1, 2, 3, 4, 5], DesignSubTask::class, 'priority');
setState($factory, [0, 1], DesignSubTask::class, 'is_main');

$factory->define(DevTask::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('10su');
    return [
        'number' => $number,
        'source_project_id' => 0,
        'promulgator_id' => $user->id,
        'promulgator_name' => $user->name,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'priority' => 1,
        'expiration_date' => $faker->date(),
        'content' => $faker->text(3000),
        'status' => 0,
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5, 6, 7], DevTask::class, 'status');
setState($factory, [1, 2, 3, 4, 5], DevTask::class, 'priority');

$factory->define(DevSubTask::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('10isu');
    return [
        'number' => $number,
        'priority' => 1,
        'expiration_date' => $faker->dateTime(),
        'description' => $faker->text(),
        'handler_id' => $user->id,
        'handler_name' => $user->name,
        'share_address' => ["\\10.1.1.59\共享\设计\个人共享\视觉设计\Rose孙正\10.25研发工作管理系统"],
        'status' => 0,
        'is_main' => 1,
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5], DevSubTask::class, 'status');
setState($factory, [1, 2, 3, 4, 5], DevSubTask::class, 'priority');
setState($factory, [0, 1], DevSubTask::class, 'is_main');

$factory->define(TestTask::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('10su');
    return [
        'number' => $number,
        'source_project_id' => 0,
        'promulgator_id' => $user->id,
        'promulgator_name' => $user->name,
        'principal_user_id' => $user->id,
        'principal_user_name' => $user->name,
        'priority' => 1,
        'expiration_date' => $faker->date(),
        'content' => $faker->text(3000),
        'status' => 0,
        'result' => 0,
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4, 5, 6], TestTask::class, 'status');
setState($factory, [1, 2, 3, 4, 5], TestTask::class, 'priority');

$factory->define(TestSubTask::class, function (Faker $faker) {
    [$user,] = userAndDept($faker);
    $number = Carbon::now()->format('10isu');
    return [
        'number' => $number,
        'priority' => 1,
        'expiration_date' => $faker->dateTime(),
        'description' => $faker->text(),
        'handler_id' => $user->id,
        'handler_name' => $user->name,
        'share_address' => ["\\10.1.1.59\共享\设计\个人共享\视觉设计\Rose孙正\10.25研发工作管理系统"],
        'status' => 0,
        'result' => 0,
        'feedback' => $faker->text(),
        'is_main' => 1,
        'start_time' => $faker->dateTime(),
        'finish_time' => $faker->dateTime(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
setState($factory, [0, 1, 2, 3, 4], TestSubTask::class, 'status');
setState($factory, [1, 2, 3, 4, 5], TestSubTask::class, 'priority');
setState($factory, [0, 1], TestSubTask::class, 'is_main');

$factory->define(LabelCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'is_open' => random_int(0, 1),
        'sort' => random_int(0, 100),
    ];
});

$factory->define(Label::class, function (Faker $faker) {
    $labelCategory = factory(LabelCategory::class)->create();
    return [
        'label_category_id' => $labelCategory->id,
        'name' => $faker->name,
        'is_open' => random_int(0, 1),
        'sort' => random_int(0, 100),
    ];
});
