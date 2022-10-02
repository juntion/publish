<?php

namespace Modules\Route\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class MenuTest extends AdminTestCase
{
    private static $fetchMenu = 'route/admin/fetchMenu';
    private static $menuUri = 'route/menus';
    private static $treeUri = 'route/menuRouteTrees';

    public function testFetchMenu()
    {
        $this->getJson(self::$fetchMenu)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['index', 'menu']]);
    }

    public function testStoreMenu()
    {
        $response = $this->postJson(self::$menuUri, [
            'parent_uuid' => null,
            'guard_name' => config('auth.defaults.guard'),
            'name' => $this->faker()->unique()->regexify('^[a-z]+(\.[a-z]+){0,2}$'),
            'icon' => 'ios-settings-outline',
            'locale' => config('app.locales'),
            'comment' => $this->faker()->text(255),
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['menu']]);

        $data = json_decode($response->content(), true);
        return $data['data']['menu']['uuid'];
    }

    /**
     * @depends testStoreMenu
     */
    public function testUpdateMenu($uuid)
    {
        $response = $this->patchJson(self::$menuUri . '/' . $uuid, [
            'parent_uuid' => null,
            'guard_name' => config('auth.defaults.guard'),
            'name' => $this->faker()->unique()->regexify('^[a-z]+(\.[a-z]+){0,2}$'),
            'icon' => 'ios-settings-outline',
            'locale' => config('app.locales'),
            'comment' => $this->faker()->text(255),
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['menu']]);
    }

    /**
     * @depends testStoreMenu
     */
    public function testMenuRoutes($uuid)
    {
        $this->getJson(self::$menuUri . '/' . $uuid . '/routes')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['routes']]);
    }

    /**
     * @depends testStoreMenu
     */
    public function testSycnMenuRoutes($uuid)
    {
        $this->postJson(self::$menuUri . '/' . $uuid . '/routes', ['routes' => []])
            ->assertSuccessful();
    }

    /**
     * @depends testStoreMenu
     */
    public function testDestroyMenuRouteTreeNode($uuid)
    {
        $guard = config('auth.defaults.guard');
        $response = $this->deleteJson(self::$treeUri . '/' . $guard . '/nodes/' . $uuid, [
            "parent_uuid" => null,
            "node_type" => "menu",
            "sort" => []
        ])
            ->assertSuccessful(['status' => 'success']);
    }
}
