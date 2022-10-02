<?php

namespace Tests\Feature\Department;

use App\Models\Department;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    protected $departments;

    protected function setUp(): void
    {
        parent::setUp();
        $this->departments = factory(Department::class, 5)->create();
    }

    /**
     * @test
     */
    public function store()
    {
        $parent = $this->faker()->randomElement($this->departments);
        $data = [
            'parent_id' => $parent ? $parent->id : 0,
            'name' => $this->faker()->name,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
        ];
        $response = $this->post('/departments', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data']['department'];
    }

    /**
     * @test
     * @depends store
     * @param $department
     */
    public function update($department)
    {
        $data = [
            'parent_id' => 0,
            'name' => $this->faker()->name,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
        ];
        $response = $this->patch('/departments/' . $department->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $department
     */
    public function getUsers($department)
    {
        $response = $this->get('/departments/' . $department->id . '/getUsers', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $department
     */
    public function getDepartments($department)
    {
        $response = $this->get('/departments/' . $department->id . '/getDepartments', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $department
     */
    public function getAllDepartments($department)
    {
        $data = ['department_id' => $department->id];
        $response = $this->post('/departments/getAllDepartments', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function tree()
    {
        $response = $this->get('/departments/tree', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function all()
    {
        $response = $this->get('/departments/all', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $department
     */
    public function deleteDepartment($department)
    {
        $response = $this->delete('/departments/' . $department->id, [], $this->headers);
        if ($department->is_base == 1) {
            $response->assertJsonFragment($this->errorStructure());
        } else {
            $response->assertJsonFragment($this->successStructure());
        }
    }
}
