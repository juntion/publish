<?php

namespace Tests\Feature\User;

use App\Models\Position;
use App\Models\User;
use Tests\TestCase;

class PositionTest extends TestCase
{
    protected $users;
    protected $positions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->users = factory(User::class, 5)->create();
        $this->positions = Position::all();
    }

    /**
     * @test
     */
    public function setPosition()
    {
        $user = $this->faker()->randomElement($this->users);
        $positions = $this->faker()->randomElements($this->positions, 3);
        $data = [
            'position_ids' => collect($positions)->pluck('id')->toArray(),
        ];
        $response = $this->post('/users/' . $user->id . '/positions', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function batchSetPosition()
    {
        $users = $this->faker()->randomElements($this->users, 3);
        $position = $this->faker()->randomElement($this->positions);
        $data = [
            'position_id' => $position->id,
            'user_ids' => collect($users)->pluck('id')->toArray(),
        ];
        $response = $this->post('/users/positions', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
