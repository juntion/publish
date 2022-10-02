<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Entities\Base\OssTempUpload;
use Modules\Base\Tests\AdminTestCase;
use Modules\Share\Entities\Key;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Entities\ResourceCustomCategory;
use Modules\Share\Entities\ResourceTag;

class ResourceTest extends AdminTestCase
{
    // resource
    private static $resourceTagsCollection = '/share/resource/resourcesTagsCollection?filter[type]=picture&limit=15&page=1';
    private static $resource = '/share/resource/resourcesCategoriesTagsCollection/';
    private static $baseResource = '/share/resource/resources/';
    private static $batchDownload = '/share/resource/resources/downloadBatch';
    private static $search = '/share/resource/search/resourcesTagsCollection?limit=15&page=1&filter[type]=picture';

    private static $uuid;
    private static $originCate;
    private static $newCate;
    private static $copyCate;
    private static $customerCate;
    private static $tag;
    private static $temp;

    public function insertTemp()
    {
        $temp = OssTempUpload::factory()->create();
        self::$temp = $temp;
        return $temp->uuid;
    }

    public function testResourcesTagsCollection()
    {
        $this->getJson(self::$resourceTagsCollection)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['resources', 'paginate']]);
    }

    public function testStoreResource()
    {
        $uploadCate = ResourceCustomCategory::factory()->create();
        $cate = ResourceCategory::factory()->create();
        $uuid = $this->insertTemp();
        self::$uuid = $uuid;
        self::$originCate = $cate;
        self::$customerCate = $uploadCate;
        $this->postJson(self::$baseResource, [
            'resources'            => [
                [
                    'uuid'     => $uuid,
                    'name'     => $this->faker->text(15),
                    'duration' => 0
                ],
            ],
            'type'                 => $this->faker->randomElement(['picture', 'video']),
            'category_uuid'        => $cate->uuid,
            'custom_category_uuid' => $uploadCate->uuid,
        ])->assertSuccessful();
    }

    public function testUpdate()
    {
        $this->patchJson(self::$baseResource.self::$uuid, [
            'name'          => $this->faker->text(15),
            'category_uuid' => self::$originCate->uuid
        ])->assertSuccessful();
    }

    public function testBatchUpdate()
    {
        $this->patchJson(self::$baseResource.'batch', [
            'name'          => $this->faker->text(15),
            'category_uuid' => self::$originCate->uuid,
            'uuid'          => [self::$uuid]
        ])->assertSuccessful();
    }

    public function testDownload()
    {
        $this->postJson(self::$baseResource.self::$uuid.'/download')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['url']]);;
    }

    public function testBatchDownload()
    {
        $this->postJson(self::$batchDownload, [
            'resource_uuid' => [self::$uuid]
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['urls']]);
    }

    public function testSearchResourcesTagsCollection()
    {
        $key = $this->faker->text(5);
        $this->postJson(self::$search, [
            'key' => $key,
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['resources', 'paginate']]);
        Key::query()->where('key', $key)->delete();
    }

    public function testAddCate()
    {
        $copyCate = ResourceCategory::factory()->create();
        self::$copyCate = $copyCate;
        $this->postJson(self::$baseResource.self::$uuid.'/categories', [
            'category_uuid' => $copyCate->uuid,
        ])->assertSuccessful();
    }

    public function testMoveCate()
    {
        $newCate = ResourceCategory::factory()->create();
        self::$newCate = $newCate;
        $this->patchJson(self::$baseResource.self::$uuid.'/categories', [
            'category_uuid'        => $newCate->uuid,
            'origin_category_uuid' => self::$copyCate->uuid
        ])->assertSuccessful();
    }

    public function testGetLogs()
    {
        $this->getJson(self::$baseResource.self::$uuid.'/logs?page=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['logs', 'paginate']]);
    }

    public function testTags()
    {
        $tag = ResourceTag::factory()->create();
        self::$tag = $tag;
        $this->postJson(self::$baseResource.self::$uuid.'/tags', [
            'tag_uuid' => [$tag->uuid],
        ])
            ->assertSuccessful();
    }

    public function testDeleteTags()
    {
        $this->deleteJson(self::$baseResource.self::$uuid.'/tags/'.self::$tag->uuid)
            ->assertSuccessful();
    }

    public function testDeleteResource()
    {
        $this->deleteJson(self::$baseResource.self::$uuid)
            ->assertSuccessful();
        self::$copyCate->delete();
        self::$originCate->delete();
        self::$newCate->delete();
        self::$tag->delete();
        self::$temp->delete();
    }
}
