<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;
use Modules\Share\Entities\Collection;
use Modules\Share\Entities\Resource;

class CollectionTest extends AdminTestCase
{
    // collection 相关
    private static $cateBase = '/share/admin/collection/categories/';
    private static $topCate = '/share/admin/collection/top/categories';
    private static $CategoryCategories = '/share/admin/collection/categories/';
    private static $storeCategories = '/share/admin/collection/categories';
    private static $collectionMix = '/share/admin/collection/categoriesMixCollections';
    private static $collectionBase = '/share/admin/collection/collections/';
    private static $type;

    public function testCollectionTopCategories()
    {
        $this->getJson(self::$topCate.'?filter[type]=picture')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['categories']]);
    }

    public function testCollectionStoreCategory()
    {
        $type = $this->faker()->randomElement(['picture', 'video']);
        self::$type = $type;
        $response = $this->postJson(self::$storeCategories, [
            'name' => $this->faker()->text(15),
            'type' => $type,
            'sort' => $this->faker()->numberBetween(0, 255)
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['category']]);

        $data = json_decode($response->content(), true);
        return $data['data']['category']['uuid'];
    }


    /**
     * @depends testCollectionStoreCategory
     */
    public function testCollectionCategoryCategories($uuid)
    {
        $this->getJson(self::$CategoryCategories.$uuid.'/categories')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['categories']]);
    }

    /**
     * @depends testCollectionStoreCategory
     * @param $uuid
     */
    public function testCollectionUpdateCategory($uuid)
    {
        $this->patchJson(self::$cateBase.$uuid, [
            'name' => $this->faker()->text(15),
            'sort' => $this->faker()->numberBetween(0, 255)
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['category']]);
    }

    /**
     * @depends testCollectionStoreCategory
     * @param $uuid
     */
    public function testCollection($uuid)
    {
        $resource = Resource::factory()->create();
        $response = $this->postJson(self::$collectionBase, [
            'resource_uuid' => $resource->uuid,
            'category_uuid' => $uuid
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['collection']]);
        $data = json_decode($response->content(), true);
        return $data['data']['collection']['uuid'];
    }


    /**
     * @depends testCollectionStoreCategory
     * @param $uuid
     */
    public function testBatchCollection($uuid)
    {
        $resource = Resource::factory()->create();
        $this->postJson(self::$collectionBase.'batch', [
            'resource_uuid' => [$resource->uuid],
            'category_uuid' => $uuid
        ])->assertSuccessful()->assertJsonStructure(['data' => ['collections']]);
    }

    /**
     * @depends testCollection
     * @param $uuid
     */
    public function testDeleteCollection($uuid)
    {
        $this->deleteJson(self::$collectionBase.$uuid)->assertSuccessful();
    }

    public function testBatchDeleteCollection()
    {
        $uuid = Collection::query()->orderBy('created_at', "DESC")->first()->uuid;
        $this->deleteJson(self::$collectionBase.'batch', [
            "uuid" => [
                $uuid
            ]
        ])->assertSuccessful();
    }

    public function testCollectionGetMixResource()
    {
        $this->postJson(self::$collectionMix.'?page=1&filter[type]='.self::$type)->assertSuccessful()
            ->assertJsonStructure(['data' => ['mixs', 'paginate']]);
    }

    /**
     * @depends testCollectionStoreCategory
     * @param $uuid
     */
    public function testCollectionDeleteCategory($uuid)
    {
        $this->deleteJson(self::$cateBase.$uuid)->assertSuccessful();
    }


}
