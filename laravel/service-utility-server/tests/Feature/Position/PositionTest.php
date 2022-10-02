<?php

namespace Tests\Feature\Position;

use App\Models\Position;
use Tests\TestCase;

class PositionTest extends TestCase
{
    protected $positions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->positions = Position::all();
    }

    /**
     * @test
     */
    public function store()
    {
        $data = [
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name])
        ];
        $response = $this->post('/positions', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data']['position'];
    }

    /**
     * @test
     * @depends store
     * @param $position
     */
    public function update($position)
    {
        $data = [
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name])
        ];
        $response = $this->patch('/positions/' . $position->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $position
     */
    public function deletePosition($position)
    {
        $response = $this->delete('/positions/' . $position->id, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function users()
    {
        $position = $this->faker()->randomElement($this->positions);
        $response = $this->get('/positions/' . $position->id . '/users', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function all()
    {
        $response = $this->get('/positions/all', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function list()
    {
        $response = $this->get('/positions?include[]=posts', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
