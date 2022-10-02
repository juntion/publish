<?php

namespace Tests\Feature\User;

use App\Models\Department;
use App\Models\User;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    protected $users;
    protected $departments;

    protected function setUp(): void
    {
        parent::setUp();

        $this->users = factory(User::class, 5)->create();
        $this->departments = factory(Department::class, 5)->create();
    }

    /**
     * @test
     */
    public function setDefaultDepartment()
    {
        $user = $this->faker()->randomElement($this->users);
        $department = $this->faker()->randomElement($this->departments);
        $response = $this->post('/users/' . $user->id . '/departments', ['department_id' => $department->id], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function batchSetDefaultDepartment()
    {
        $users = $this->faker()->randomElements($this->users, 3);
        $department = $this->faker()->randomElement($this->departments);
        $data = [
            'user_ids' => collect($users)->pluck('id')->toArray(),
            'department_id' => $department->id,
        ];
        $response = $this->post('/users/departments', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function setOtherDepartment()
    {
        $user = $this->faker()->randomElement($this->users);
        $departments = $this->faker()->randomElements($this->departments, 3);
        $data = ['department_id' => collect($departments)->pluck('id')->toArray()];
        $response = $this->post('/users/' . $user->id . '/otherDepartments', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
