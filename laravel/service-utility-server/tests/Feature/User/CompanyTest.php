<?php

namespace Tests\Feature\User;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    protected $users;
    protected $companies;

    protected function setUp(): void
    {
        parent::setUp();

        $this->users = factory(User::class, 5)->create();
        $this->companies = Company::all();
    }

    /**
     * 子公司列表
     * @test
     */
    public function companies()
    {
        $response = $this->get('/companies');
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function setUserCompany()
    {
        $user = $this->faker()->randomElement($this->users);
        $company = $this->faker()->randomElement($this->companies);
        $response = $this->post('/users/' . $user->id . '/companies', ['company_id' => $company->id], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function batchSetUserCompany()
    {
        $users = $this->faker()->randomElements($this->users, 5);
        $company = $this->faker()->randomElement($this->companies);
        $data = [
            'company_id' => $company->id,
            'user_ids' => collect($users)->pluck('id')->toArray(),
        ];
        $response = $this->post('/users/companies', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
