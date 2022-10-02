<?php

namespace Tests\Unit\Rpc;

use App\Models\Department;
use App\Models\User;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Demand;
use App\Rpc\Service\ErpService;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ErpServiceTest extends TestCase
{
    /**
     * @var ErpService
     */
    protected $erpService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->erpService = new ErpService();
    }

    /**
     * @test
     */
    public function getUserByOriginId()
    {
        $users = User::query()->where('origin_id', '>', 0)->limit(5)->get();
        $deleteUsers = User::query()->where('origin_id', '>', 0)
            ->whereNotNull('deleted_at')->withTrashed()->limit(5)->get();

        $user = $this->faker->randomElement($users);
        $deleteUser = $this->faker->randomElement($deleteUsers);
        $r1 = $this->erpService->getUserByOriginId($user->origin_id);
        $this->assertEquals($user->id, $r1['data']['id']);

        $r2 = $this->erpService->getUserByOriginId($deleteUser->origin_id);
        $this->assertEquals($deleteUser->id, $r2['data']['id']);

        $r3 = $this->erpService->getUserByOriginId($deleteUser->origin_id, ['*'], false);
        $this->assertEquals('error', $r3['status']);
    }

    /**
     * @test
     */
    public function getUsersByOriginIds()
    {
        $users = User::query()->where('origin_id', '>', 0)->limit(5)->get();
        $deleteUsers = User::query()->where('origin_id', '>', 0)
            ->whereNotNull('deleted_at')->withTrashed()->limit(5)->get();

        $r1 = $this->erpService->getUsersByOriginIds($users->pluck('origin_id')->toArray());
        $this->assertEquals($users->count(), count($r1['data']['users']));

        $r2 = $this->erpService->getUsersByOriginIds($deleteUsers->pluck('origin_id')->toArray());
        $this->assertEquals($deleteUsers->count(), count($r2['data']['users']));

        $r3 = $this->erpService->getUsersByOriginIds($deleteUsers->pluck('origin_id')->toArray(), ['*'], false);
        $this->assertEquals(0, count($r3['data']['users']));
    }

    /**
     * @test
     */
    public function getDeptByOriginId()
    {
        $dept = Department::query()->first();
        $res = $this->erpService->getDeptByOriginId($dept->origin_id, true);
        $this->assertEquals($dept->id, $res['data']['id']);
    }

    /**
     * @test
     */
    public function getDeptsByOriginIds()
    {
        $depts = Department::query()->limit(5)->get();
        $res = $this->erpService->getDeptsByOriginIds($depts->pluck('origin_id'), true);
        $this->assertEquals($depts->count(), count($res['data']['depts']));
    }

    /**
     * @test
     */
    public function getDeptTopByOriginId()
    {
        $dept = Department::query()->where('parent_id', '>', 0)->first();
        $topId = Arr::first($dept->parent_ids);
        $res = $this->erpService->getDeptTopByOriginId($dept->origin_id);
        $this->assertEquals($topId, $res['data']['id']);
    }

    /**
     * @test
     */
    public function getDemandsData()
    {
        $appeal = Demand::query()->first(['number']);
        $res = $this->erpService->getDemandsData($appeal->number, ['number']);
        $this->assertEquals($appeal->number, $res['data'][$appeal->number]['number']);

        $res = $this->erpService->getDemandsData([$appeal->number], ['number']);
        $this->assertEquals($appeal->number, $res['data'][$appeal->number]['number']);

        $res = $this->erpService->getDemandsData([$appeal->number], ['id']);
        $this->assertEquals($appeal->number, $res['data'][$appeal->number]['number']);
    }

    /**
     * @test
     */
    public function getAppealsData()
    {
        $appeal = Appeal::query()->first(['number']);
        $res = $this->erpService->getAppealsData($appeal->number, ['number']);
        $this->assertEquals($appeal->number, $res['data'][$appeal->number]['number']);

        $res = $this->erpService->getAppealsData([$appeal->number], ['number']);
        $this->assertEquals($appeal->number, $res['data'][$appeal->number]['number']);

        $res = $this->erpService->getAppealsData([$appeal->number], ['id']);
        $this->assertEquals($appeal->number, $res['data'][$appeal->number]['number']);
    }
}
