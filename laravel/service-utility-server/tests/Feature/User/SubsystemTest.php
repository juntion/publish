<?php

namespace Tests\Feature\User;

use App\Models\Subsystem;
use App\Models\User;
use Tests\TestCase;

class SubsystemTest extends TestCase
{
    /**
     * @test
     */
    public function addUserForbid()
    {
        $user = User::query()->first();
        $subsystem = Subsystem::query()->first();
        $response = $this->post('/users/' . $user->id . '/subsystems/forbid', ['subsystem_id' => $subsystem->id], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * 查询用户禁止登录的系统
     * @test
     */
    public function getForbidUser()
    {
        $user = User::query()->first();
        $response = $this->get('/users/' . $user->id . '/subsystems/forbid', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function removeUserForbid()
    {
        $user = User::query()->first();
        $subsystem = Subsystem::query()->first();
        $response = $this->delete('/users/' . $user->id . '/subsystems/forbid', ['subsystem_id' => $subsystem->id], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
