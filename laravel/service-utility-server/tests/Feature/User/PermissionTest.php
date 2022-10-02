<?php

namespace Tests\Feature\User;

use App\Models\Permission\Permission;
use App\Models\User;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    /**
     * @test
     */
    public function permissions()
    {
        $user = User::query()->first();
        $response = $this->post('users/' . $user->id . '/permissions', ['guard_name' => 'uums'], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function syncPermissions()
    {
        $guardName = config('app.guard');
        $users = factory(User::class, 5)->create();
        $user = $this->faker()->randomElement($users);
        $permissions = Permission::query()->where('guard_name', $guardName)->get()->toArray();
        $permissions = $this->faker()->randomElements($permissions, 3);
        $data = [
            'permission_ids' => collect($permissions)->pluck('id')->toArray(),
            'guard_name' => $guardName,
        ];
        $response = $this->patch('/users/' . $user->id . '/permissions', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
