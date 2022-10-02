<?php

namespace Modules\Admin\Tests\Feature\Auth;

use Modules\Admin\Entities\Admin;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private static $uriLogin = 'admin/auth/login';
    private static $uriFetch = 'admin/auth/fetchUser';
    private static $uriLogout = 'admin/auth/logout';

    private static $admin;

    public function getAdmin()
    {
        if (!self::$admin) {
            self::$admin = Admin::factory()->create();
        }
        return self::$admin;
    }

    public function testLogin()
    {
        $response = $this->postJson(self::$uriLogin, [
            'username' => $this->getAdmin()->email,
            'password' => 'password',
            'remember' => false
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['admin', 'accessToken', 'tokenType', 'expiresIn']]);

        $data = json_decode($response->content(), true);
        $token = $data['data']['tokenType'] . ' ' . $data['data']['accessToken'];
        return $token;
    }

    public function testFetchCurrentUser()
    {
        $this->actingAs($this->getAdmin(), 'admin')
            ->getJson(self::$uriFetch)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['admin']]);
    }

    /**
     * @depends testLogin
     */
    public function testLogout($token)
    {
        $headers = [
            'Authorization' => $token
        ];

        $this->getJson(self::$uriLogout, $headers)
            ->assertSuccessful();

        $this->getAdmin()->delete();
    }
}
