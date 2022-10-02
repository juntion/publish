<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function login()
    {
        $user = User::query()->orderBy('id', 'desc')->first();
        $data = [
            'username' => $user->name,
            'password' => 'password',
            'guard_name' => 'uums',
        ];
        $response = $this->post('/auth/login', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function logout()
    {
        $response = $this->post('/auth/logout');
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function amILogin()
    {
        $response = $this->get('/amILogin');
        $response->assertJsonFragment($this->successStructure());

        Auth::logout();
        $response = $this->get('/amILogin');
        $response->assertStatus(401);
    }

    /** @test */
    public function refresh()
    {
        $response = $this->post('/auth/refresh/' . $this->user->id);
        $response->assertJsonFragment($this->successStructure());
    }
}
