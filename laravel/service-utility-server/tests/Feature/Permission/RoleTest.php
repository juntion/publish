<?php

namespace Tests\Feature\Permission;

use App\Models\Permission\Permission;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * @test
     */
    public function store()
    {
        $data = [
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
            'guard_name' => 'uums',
        ];
        $response = $this->post('/roles', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data']['role'];
    }

    /**
     * @test
     * @depends store
     * @param $role
     */
    public function update($role)
    {
        $data = [
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
        ];
        $response = $this->patch('/roles/' . $role->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function list()
    {
        $response = $this->get('/roles', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function all()
    {
        $response = $this->post('/roles/all', ['guard_name' => 'uums'], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $role
     */
    public function givePermissions($role)
    {
        $permissions = Permission::query()->limit(10)->pluck('id')->toArray();
        $response = $this->patch('/roles/' . $role->id . '/permissions', ['permission_ids' => $permissions], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $role
     */
    public function getPermissions($role)
    {
        $response = $this->get('/roles/' . $role->id . '/permissions', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $role
     */
    public function deleteRole($role)
    {
        $response = $this->delete('/roles/' . $role->id, [], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
