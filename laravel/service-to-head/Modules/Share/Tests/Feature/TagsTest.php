<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;
use Modules\Share\Entities\Key;

class TagsTest extends AdminTestCase
{
    private static $base = '/share/tag/tags/';
    private static $search = '/share/tag/search/tags';

    public function testTagsList()
    {
        $this->getJson(self::$base.'?limit=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['tags', 'paginate']]);
    }

    public function testStoreTag()
    {
        $response = $this->postJson(self::$base, [
            'name' => $this->faker()->text(15)
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['tag']]);
        $data = json_decode($response->content(), true);
        return $data['data']['tag']['uuid'];
    }

    /**
     * @depends testStoreTag
     * @param $uuid
     */
    public function testUpdateTag($uuid)
    {
        $this->patchJson(self::$base.$uuid, [
            'name' => $this->faker()->text(15)
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['tag']]);
    }

    /**
     * @depends testStoreTag
     * @param $uuid
     */
    public function testCloseTag($uuid)
    {
        $this->patchJson(self::$base.$uuid.'/close')->assertSuccessful();
    }

    /**
     * @depends testStoreTag
     * @param $uuid
     */
    public function testOpenTag($uuid)
    {
        $this->patchJson(self::$base.$uuid.'/open')->assertSuccessful();
    }

    /**
     * @depends testStoreTag
     * @param $uuid
     */
    public function testDeleteTag($uuid)
    {
        $this->deleteJson(self::$base.$uuid)
            ->assertSuccessful();
    }

    public function testSearch()
    {
        $key = $this->faker->text(5);
        $this->postJson(self::$search, [
            'key' => $key
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['tags']]);
        Key::query()->where('key', $key)->delete();
    }
}
