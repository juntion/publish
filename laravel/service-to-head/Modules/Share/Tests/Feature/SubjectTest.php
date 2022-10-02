<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Entities\Base\OssTempUpload;
use Modules\Base\Tests\AdminTestCase;
use Modules\Share\Entities\Key;

class SubjectTest extends AdminTestCase
{
    private static $base = '/share/subject/subjects/';
    private static $search = '/share/subject/search/subjects';
    private static $temp;

    public function insertTemp()
    {
        $temp = OssTempUpload::factory()->create();
        self::$temp = $temp;
        return $temp->uuid;
    }

    public function testSubjectsList()
    {
        $this->getJson(self::$base.'?limit=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['subjects', 'paginate']]);
    }

    public function testStoreSubject()
    {
        $uuid = $this->insertTemp();
        $response = $this->postJson(self::$base, [
            'name'            => $this->faker()->text(15),
            'sort'            => $this->faker->numberBetween(0, 255),
            'background_uuid' => $uuid
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['subject']]);
        $data = json_decode($response->content(), true);
        return $data['data']['subject']['uuid'];
    }

    /**
     * @depends testStoreSubject
     * @param $uuid
     */
    public function testUpdateSubject($uuid)
    {
        $this->patchJson(self::$base.$uuid, [
            'name' => $this->faker()->unique()->name,
            'sort' => $this->faker->numberBetween(0, 255),
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['subject']]);
    }

    /**
     * @depends testStoreSubject
     * @param $uuid
     */
    public function testCloseSubject($uuid)
    {
        $this->patchJson(self::$base.$uuid.'/close')->assertSuccessful();
    }

    /**
     * @depends testStoreSubject
     * @param $uuid
     */
    public function testOpenSubject($uuid)
    {
        $this->patchJson(self::$base.$uuid.'/open')->assertSuccessful();
    }

    /**
     * @depends testStoreSubject
     * @param $uuid
     */
    public function testGetResourceTags($uuid)
    {
        $this->postJson(self::$base.$uuid.'/resourcesTagsCollection?filter[type]=picture&limit=15&page=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['resources', 'paginate']]);
    }

    /**
     * @depends testStoreSubject
     * @param $uuid
     */
    public function testDeleteSubject($uuid)
    {
        $this->deleteJson(self::$base.$uuid)
            ->assertSuccessful();
        self::$temp->delete();
    }

    public function testSearch()
    {
        $key = $this->faker->text(5);
        $this->postJson(self::$search, [
            'key' => $key
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['subjects']]);
        Key::query()->where('key', $key)->delete();
    }
}
