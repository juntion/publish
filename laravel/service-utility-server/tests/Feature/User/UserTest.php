<?php

namespace Tests\Feature\User;

use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $departments;
    protected $positions;
    protected $companies;

    protected function setUp(): void
    {
        parent::setUp();

        $this->departments = factory(Department::class, 5)->create();
        $this->positions = Position::all();
        $this->companies = Company::all();
    }

    /**
     * 获取当前登录用户信息
     * @test
     */
    public function getLoginUser()
    {
        $response = $this->get('/userInfo');
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * 用户列表
     * @test
     */
    public function index()
    {
        $response = $this->get('/users');
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function store()
    {
        $positions = $this->faker()->randomElements($this->positions, 3);
        $department = $this->faker()->randomElement($this->departments);
        $company = $this->faker()->randomElement($this->companies);
        $data = [
            'name' => $this->faker()->unique()->firstName,
            'email' => $this->faker()->unique()->email,
            'position_ids' => collect($positions)->pluck('id')->toArray(),
            'department_id' => $department->id,
            'company_id' => $company->id,
        ];
        $response = $this->post('/users', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data']['user'];
    }

    /**
     * @test
     * @depends store
     * @param $user
     */
    public function show($user)
    {
        $response = $this->get('/users/' . $user['id'], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $user
     */
    public function update($user)
    {
        $data = [
            'name' => $this->faker()->unique()->firstName,
            'email' => $this->faker()->unique()->email,
        ];
        $response = $this->patch('/users/' . $user['id'], $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function adminLevel()
    {
        $response = $this->get('/users/adminLevel', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $user
     */
    public function setDuty($user)
    {
        $response = $this->post('/users/' . $user['id'] . '/setDuty', ['duties' => 2], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $user
     */
    public function resetPassword($user)
    {
        $password = Str::random(8);
        $data = [
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $response = $this->post('/users/' . $user['id'] . '/resetPassword', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $user
     */
    public function deleteUser($user)
    {
        $response = $this->delete('/users/' . $user['id'], [], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function loginHistory()
    {
        $response = $this->get('/user/loginHistory', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
