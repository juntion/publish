<?php

namespace Modules\Base\Tests\Feature;


use Modules\Base\Entities\Base\OpenAuth;
use Modules\Base\Tests\AdminTestCase;

class OpenAuthTest extends AdminTestCase
{
    private static $openAuthView = 'base/open/auth/tokens';
    private static $openAuthToken = 'base/open/auth/token';
    
    public function testListCollection()
    {
        $this->getJson(self::$openAuthView . '?limit=10&page=1')->assertSuccessful();
    }
    
    public function testGetToken()
    {
        $response = $this->postJson(self::$openAuthToken, [
            'exp_time' => 3600,
            'remarks' => 'Test',
        ])->assertSuccessful()->assertJsonStructure(['data' => ['auth_token']]);
        return $response['data']['auth_token']['access_key_id'];
    }
    
    /**
     * @depends testGetToken
     * @param $uuid
     */
    public function testTokenStatus($uuid)
    {
        $this->patchJson(self::$openAuthToken . '/' .$uuid . '/status', ['status' => 1])->assertSuccessful();
        OpenAuth::query()->whereKey($uuid)->delete();
    }
}