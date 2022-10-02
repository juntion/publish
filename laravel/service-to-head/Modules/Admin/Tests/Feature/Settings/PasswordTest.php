<?php

namespace Modules\Admin\Tests\Feature\Settings;

use Modules\Base\Tests\AdminTestCase;

class PasswordTest extends AdminTestCase
{
    private static $passwordUri = 'admin/settings/password';

    public function testUpdatePassword()
    {
        $this->patchJson(self::$passwordUri, [
            'password_old' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertSuccessful();
    }
}