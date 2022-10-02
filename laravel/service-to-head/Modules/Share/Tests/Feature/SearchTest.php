<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;
use Modules\Share\Entities\Key;

class SearchTest extends AdminTestCase
{
    private static $hotKeys = '/share/search/hot/keys';
    private static $keysTags = '/share/search/keysTags';

    public function testHotKeys()
    {
        $this->getJson(self::$hotKeys)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['keys']]);
    }

    public function testDownloads()
    {
        $key = $this->faker->text(5);
        $this->postJson(self::$keysTags, [
            'key' => $key
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['keys', 'tags']]);
        Key::query()->where('key', $key)->delete();
    }
}
