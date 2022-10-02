<?php

namespace Modules\Route\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class RouteTest extends AdminTestCase
{
    private static $route = 'route/routes';

    public function testRoutes()
    {
        $this->getJson(self::$route . '?limit=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['routes', 'paginate']]);
    }

    public function testAdminGuardRoutes()
    {
        $this->getJson(self::$route . '?filter[guard_name]=admin')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['routes']]);
    }
}
