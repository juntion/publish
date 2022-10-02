<?php

namespace Tests\Feature\User;

use App\Models\Permission\Role;
use App\Models\User;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * @test
     */
    public function roles()
    {
        $user = User::query()->first();
        $response = $this->post('/users/' . $user->id . '/roles', ['guard_name' => config('app.guard')], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function getRolesAndPermissions()
    {
        $user = User::query()->first();
        $response = $this->post('/users/' . $user->id . '/getRolesAndPermissions', ['guard_name' => config('app.guard')], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function syncRoles()
    {
        $user = User::query()->latest('id')->first();
        $roles = Role::all();
        $data = [
            'role_ids' => $roles->pluck('id')->toArray(),
            'guard_name' => config('app.guard'),
        ];
        $response = $this->patch('/users/' . $user->id . '/roles', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
