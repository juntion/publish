<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class UploadTest extends AdminTestCase
{
    // upload相关
    private static $uploadCateBase = '/share/admin/upload/categories/';
    private static $uploadTopCate = '/share/admin/upload/top/categories';
    private static $uploadCategoryCategories = '/share/admin/upload/categories/';
    private static $uploadStoreCategories = '/share/admin/upload/categories';
    private static $uploadCollectionMix = '/share/admin/upload/categoriesMixResources';
    private static $type;

    public function testUploadTopCategories()
    {
        $this->getJson(self::$uploadTopCate.'?filter[type]=picture')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['categories']]);
    }

    public function testUploadStoreCategory()
    {
        $type = $this->faker()->randomElement(['picture', 'video']);
        self::$type = $type;
        $response = $this->postJson(self::$uploadStoreCategories, [
            'name' => $this->faker()->text(15),
            'type' => $type,
            'sort' => $this->faker()->numberBetween(0, 255)
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['category']]);

        $data = json_decode($response->content(), true);
        return $data['data']['category']['uuid'];
    }


    /**
     * @depends testUploadStoreCategory
     */
    public function testUploadCategoryCategories($uuid)
    {
        $this->getJson(self::$uploadCategoryCategories.$uuid.'/categories')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['categories']]);
    }

    /**
     * @depends testUploadStoreCategory
     * @param $uuid
     */
    public function testUploadUpdateCategory($uuid)
    {
        $this->patchJson(self::$uploadCateBase.$uuid, [
            'name' => $this->faker()->text(15),
            'sort' => $this->faker()->numberBetween(0, 255)
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['category']]);
    }

    public function testUploadGetMixResource()
    {
        $this->postJson(self::$uploadCollectionMix.'?page=1&filter[type]='.self::$type)->assertSuccessful()
            ->assertJsonStructure(['data' => ['mixs', 'paginate']]);
    }

    /**
     * @depends testUploadStoreCategory
     * @param $uuid
     */
    public function testUploadDeleteCategory($uuid)
    {
        $this->deleteJson(self::$uploadCateBase.$uuid)->assertSuccessful();
    }

}
