<?php

namespace Tests\Feature\User;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SettingTest extends TestCase
{
    /**
     * @test
     */
    public function update()
    {
        $data = [
            'name' => $this->faker()->unique()->firstName,
            'email' => $this->faker()->unique()->email
        ];
        $response = $this->patch('/users/setting/userInfo', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function updatePassword()
    {
        $data = [
            'password_old' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->post('/users/setting/password', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function setAvatar()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->json('POST', '/users/setting/avatar', ['avatar' => $file], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function codeEmail()
    {
        $data = ['code_email' => 'test@feisu.com'];
        $response = $this->post('/users/setting/codeEmail', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function assistantLevel()
    {
        $response = $this->json('GET', '/users/setting/assistantLevel', ['types' => [3]], $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data'];
    }

    /**
     * @test
     * @depends assistantLevel
     * @param $assistantLevels
     */
    public function setAssistantLevel($assistantLevels)
    {
        $data = $this->faker()->randomElement($assistantLevels);
        $response = $this->post('/users/setting/assistantLevel', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
