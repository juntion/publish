<?php

namespace Tests\Feature\Permission;

use App\Models\Permission\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    /**
     * @test
     */
    public function index()
    {
        $response = $this->get('/permissions', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function group()
    {
        $response = $this->post('/permissions/groups', ['guard_name' => 'uums'], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function update()
    {
        $permission = Permission::query()->first();
        $data = [
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
        ];
        $response = $this->patch('/permissions/' . $permission->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
