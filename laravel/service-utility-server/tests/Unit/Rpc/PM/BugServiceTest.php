<?php

namespace Tests\Unit\Rpc\PM;

use App\Models\User;
use App\Rpc\Service\PM\BugService;
use Carbon\Carbon;
use Tests\TestCase;

class BugServiceTest extends TestCase
{
    /**
     * @test
     */
    public function store()
    {
        $user = User::query()->first();
        $operationUserId = $bugPromulgatorId = $user->id;
        $erpBugId = $this->faker->randomNumber();
        // bug数据
        $bugData = [
            'operation_account' => [$user->id],
            'browser' => ['Chrome'],
            'start_time' => Carbon::yesterday()->toDateTimeString(),
            'end_time' => now()->toDateTimeString(),
            'operation_platform' => random_int(1, 7),
            'is_urgent' => random_int(0, 1),
            'description' => $this->faker->paragraph(),
            'erp_bug_number' => 'S' . $erpBugId,
            'media' => [
                [
                    'name' => '123.txt',
                    'content' => 'https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=819369845,3930286256&fm=11&gp=0.jpg',
                    'user_id' => $user->id,
                    'upload_time' => now()->addDays(-1)->toDateTimeString(),
                ]
            ]
        ];
        // 审批数据
        $auditDataCount = random_int(1, 2);
        for ($i = 1; $i <= $auditDataCount; $i++) {
            $auditData[] = [
                'audit_type' => $i,
                'audit_user_id' => $user->id,
                'audit_remark' => $this->faker->sentence(),
            ];
        }
        $bugService = new BugService();
        $result = $bugService->store($operationUserId, $bugPromulgatorId, $erpBugId, $bugData, $auditData);

        $this->assertEquals('success', $result['status']);
    }
}
