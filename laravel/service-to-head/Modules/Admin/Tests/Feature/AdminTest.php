<?php

namespace Modules\Admin\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class AdminTest extends AdminTestCase
{
    private static $adminUri = 'admin/admins';

    public function testFetchAdmins()
    {
        $this->getJson(self::$adminUri . '?limit=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['admins', 'paginate']]);
    }

    public function testStoreAdmin()
    {
        $response = $this->postJson(self::$adminUri, [
            'name' => $this->faker()->unique()->regexify('^[a-z]+(\.[a-z]+){0,2}$'),
            'email' => $this->faker()->email
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['admin']]);

        $data = json_decode($response->content(), true);
        return $data['data']['admin']['uuid'];
    }

    /**
     * @depends testStoreAdmin
     */
    public function testUpdateAdmin($uuid)
    {
        $this->patchJson(self::$adminUri . '/' . $uuid, [
            'name' => $this->faker()->unique()->regexify('^[a-z]+(\.[a-z]+){0,2}$'),
            'email' => $this->faker()->email
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['admin']]);
    }

    /**
     * @depends testStoreAdmin
     */
    public function testAdminRolesPermissions($uuid)
    {
        $this->getJson(self::$adminUri . '/' . $uuid . '/rolesPermissions')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['roles', 'permissions']]);
    }

    /**
     * @depends testStoreAdmin
     */
    public function testSyncAdminRolesPermissions($uuid)
    {
        $this->putJson(self::$adminUri . '/' . $uuid . '/rolesPermissions', ['roles' => [], 'defaultRole' => '', 'permissions' => []])
            ->assertSuccessful();
    }

    /**
     * @depends testStoreAdmin
     */
    public function testDestroyAdmin($uuid)
    {
        $this->deleteJson(self::$adminUri . '/' . $uuid)
            ->assertSuccessful(['status' => 'success']);
    }

    /**
     * @depends testStoreAdmin
     */
    public function testGetAdminList()
    {
        $this->getJson(self::$adminUri . '/list')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['admins']]);
    }
}
