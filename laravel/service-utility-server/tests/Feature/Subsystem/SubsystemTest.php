<?php

namespace Tests\Feature\Subsystem;

use App\Models\Subsystem;
use App\Models\User;
use Tests\TestCase;

class SubsystemTest extends TestCase
{
    protected $subsystems;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subsystems = Subsystem::all();
    }

    /**
     * @test
     */
    public function update()
    {
        $data = [
            'name' => $this->faker()->name,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
        ];
        $subsystem = $this->faker()->randomElement($this->subsystems);
        $response = $this->patch('/subsystems/' . $subsystem->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function setHomepage()
    {
        $subsystem = $this->faker()->randomElement($this->subsystems);
        $response = $this->post('subsystems/' . $subsystem->id . '/setHomepage', ['status' => 1], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function setSidebar()
    {
        $subsystem = $this->faker()->randomElement($this->subsystems);
        $response = $this->post('subsystems/' . $subsystem->id . '/setSidebar', ['status' => 1], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function list()
    {
        $response = $this->get('/subsystems', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function addForbidUsers()
    {
        $subsystem = $this->faker()->randomElement($this->subsystems);
        $data = User::query()->limit(5)->pluck('id')->toArray();
        $response = $this->post('/subsystems/' . $subsystem->id . '/forbid/users', ['user_ids' => $data], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function removeForbidUsers()
    {
        $subsystem = $this->faker()->randomElement($this->subsystems);
        $userIds = User::query()->limit(5)->pluck('id')->toArray();
        $response = $this->delete('/subsystems/' . $subsystem->id . '/forbid/users', ['user_ids' => $userIds], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function forbidUsers()
    {
        $subsystem = $this->faker()->randomElement($this->subsystems);
        $response = $this->get('/subsystems/' . $subsystem->id . '/forbid/users', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function allowLoginUsers()
    {
        $subsystem = $this->faker()->randomElement($this->subsystems);
        $response = $this->get('/users/subsystems/' . $subsystem->id . '/allow', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function guardNames()
    {
        $response = $this->get('/subsystems/guardNames', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
