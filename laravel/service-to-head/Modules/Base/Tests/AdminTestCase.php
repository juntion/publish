<?php

namespace Modules\Base\Tests;

use Tests\TestCase;
use Modules\Admin\Entities\Admin;

abstract class AdminTestCase extends TestCase
{
    private static $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->user(), 'admin');
    }

    protected function user(): Admin
    {
        if (!self::$user) {
            self::$user = Admin::where('name', config('app.root'))->first();
        }
        return self::$user;
    }
}
