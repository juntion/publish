<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class CategoriesTest extends AdminTestCase
{
    private static $base = '/share/category/categories/';
    private static $topCategories = '/share/category/top/categories';
    private static $tree = '/share/category/trees/';
    private static $mix = '/share/category/categoriesMixResources';
    private static $type;

    public function testTopCategories()
    {
        $this->getJson(self::$topCategories.'?filter[type]=picture')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['categories']]);
    }

    public function testStoreCategory()
    {
        $type = $this->faker()->randomElement(['picture', 'video']);
        self::$type = $type;
        $response = $this->postJson(self::$base, [
            'name'       => $this->faker()->text(15),
            'type'       => $type,
            'background' => $this->faker()->text(12),
            'sort'       => $this->faker()->numberBetween(0, 255)
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['category']]);

        $data = json_decode($response->content(), true);
        return $data['data']['category']['uuid'];

    }

    /**
     * @depends testStoreCategory
     */
    public function testCategoryCategories($uuid)
    {
        $this->getJson(self::$base.$uuid.'/categories')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['categories']]);
    }

    /**
     * @depends testStoreCategory
     * @param $uuid
     */
    public function testUpdateCategory($uuid)
    {
        $this->patchJson(self::$base.$uuid, [
            'name'       => $this->faker()->text(15),
            'background' => $this->faker()->text(32),
            'sort'       => $this->faker()->numberBetween(0, 255)
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['category']]);
    }

    /**
     * @depends testStoreCategory
     * @param $uuid
     */
    public function testCloseCategory($uuid)
    {
        $this->patchJson(self::$base.$uuid.'/close')->assertSuccessful();
    }

    /**
     * @depends testStoreCategory
     * @param $uuid
     */
    public function testOpenCategory($uuid)
    {
        $this->patchJson(self::$base.$uuid.'/open')->assertSuccessful();
    }

    /**
     * @depends testStoreCategory
     * @param $uuid
     */
    public function testGetResourceTagsCollection($uuid)
    {
        $this->postJson(self::$base.$uuid.'/resourcesTagsCollection?limit=15&page=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['resources', 'paginate']]);
    }

    public function testGetTrees()
    {
        $type = $this->faker()->randomElement(['picture', 'video']);
        $this->getJson(self::$tree.$type)
            ->assertSuccessful();
    }

    /**
     * @depends testStoreCategory
     * @param $uuid
     */
    public function testUpdateTree($uuid)
    {
        $this->patchJson(self::$tree.self::$type, [
            'sort' => [
                0 => [
                    'uuid' => $uuid,
                    'sort' => $this->faker->numberBetween(0, 255)
                ]
            ]
        ])->assertSuccessful();
    }

    public function testGetMixResource()
    {
        $this->postJson(self::$mix.'?page=1')->assertSuccessful()
            ->assertJsonStructure(['data' => ['mixs', 'paginate']]);
    }

    /**
     * @depends testStoreCategory
     * @param $uuid
     */
    public function testDeleteCategory($uuid)
    {
        $this->deleteJson(self::$base.$uuid)->assertSuccessful();
    }
}
