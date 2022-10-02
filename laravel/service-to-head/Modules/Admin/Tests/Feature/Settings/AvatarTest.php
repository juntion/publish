<?php

namespace Modules\Admin\Tests\Feature\Settings;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Base\Tests\AdminTestCase;

class AvatarTest extends AdminTestCase
{
    private static $avatarUri = 'admin/settings/avatar';

    public function testAvatarUpload()
    {
        Storage::fake('public');

        $this->json('POST', self::$avatarUri, [
            'avatar' => UploadedFile::fake()->image('avatar.jpeg', 100, 100)->size(1)
        ])->assertSuccessful();

        $admin = $this->user();
        $avatarFilePath = 'avatar' . '/' . substr($admin->uuid, 0, 2) . '/' . $admin->uuid . '.jpeg';
        Storage::disk('public')->assertExists($avatarFilePath);
    }
}