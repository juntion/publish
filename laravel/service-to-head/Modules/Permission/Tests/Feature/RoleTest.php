<?php

namespace Modules\Permission\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class RoleTest extends AdminTestCase
{
    private static $roleUri = 'permission/roles';
    private static $rolesPermissionsUri = 'permission/roles/permissions';

    public function testFetchRolesPermissions()
    {
        $this->getJson(self::$rolesPermissionsUri . '?filter[guard_name]=admin')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['roles']]);
    }

    public function testFetchRoles()
    {
//        $this->getJson(self::$roleUri)
//            ->assertSuccessful()
//            ->assertJsonStructure(['data' => ['roles']]);

        $this->getJson(self::$roleUri . '?limit=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['roles', 'paginate']]);
    }

    public function testStoreRole()
    {
        $response = $this->postJson(self::$roleUri, [
            'locale' => config('app.locales'),
            'name' => $this->faker()->unique()->regexify('^[a-z]+(\.[a-z]+){0,2}$'),
            'guard_name' => config('auth.defaults.guard'),
            'comment' => $this->faker()->text(255),
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['role']]);

        $data = json_decode($response->content(), true);
        return $data['data']['role']['uuid'];
    }

    /**
     * @depends testStoreRole
     */
    public function testUpdateRole($uuid)
    {
        $this->patchJson(self::$roleUri . '/' . $uuid, [
            'locale' => config('app.locales'),
            'name' => $this->faker()->unique()->regexify('^[a-z]+(\.[a-z]+){0,2}$'),
            'guard_name' => config('auth.defaults.guard'),
            'comment' => $this->faker()->text(255),
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['role']]);
    }

    /**
     * @depends testStoreRole
     */
    public function testRolePermissions($uuid)
    {
        $this->getJson(self::$roleUri . '/' . $uuid . '/permissions')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['permissions']]);
    }

    /**
     * @depends testStoreRole
     */
    public function testRoleAdmins($uuid)
    {
        $this->getJson(self::$roleUri . '/' . $uuid . '/admins')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['admins']]);
    }

    /**
     * @depends testStoreRole
     */
    public function testSyncRolePermissions($uuid)
    {
        $this->putJson(self::$roleUri . '/' . $uuid . '/permissions', ['permissions' => []])
            ->assertSuccessful();
    }

    /**
     * @depends testStoreRole
     */
    public function testDestroyRole($uuid)
    {
        $this->deleteJson(self::$roleUri . '/' . $uuid)
            ->assertSuccessful(['status' => 'success']);
    }
}
