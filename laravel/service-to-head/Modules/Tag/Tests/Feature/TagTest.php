<?php

namespace Modules\Tag\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Base\Tests\AdminTestCase;
use Modules\Tag\Entities\TagData;

class TagTest extends AdminTestCase
{
    private static $baseUrl = '/tag/tags';

    public function testStore()
    {
        Storage::fake('public');
        $this->postJson(self::$baseUrl, $this->generateTagData())->assertSuccessful();
        $tag = TagData::query()->orderByDesc('number')->first();
        Storage::disk('public')->assertExists($tag->avatar);
        return $tag;
    }

    private function generateTagData(): array
    {
        return [
            'name' => $this->faker()->unique()->name,
            'status' => random_int(1, 2),
            'locale' => [
                'en' => $this->faker()->name,
                'cn' => $this->faker()->name,
            ],
            'type' => 1,
            'url_name' => $this->faker()->sentence,
            'avatar' => UploadedFile::fake()->image('avatar.jpeg')->size(1),
        ];
    }

    /**
     * @depends testStore
     * @param $tag
     */
    public function testAddChild($tag)
    {
        Storage::fake('public');
        $this->postJson(self::$baseUrl . "/{$tag->uuid}/child", $this->generateTagData())->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $tag
     */
    public function testUpdate($tag)
    {
        Storage::fake('public');
        $this->postJson(self::$baseUrl . "/{$tag->uuid}/update", $this->generateTagData())->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param TagData $tag
     * @throws \Exception
     */
    public function testUpdateStatus($tag)
    {
        $data = ['status' => random_int(1, 2)];
        $this->patchJson(self::$baseUrl . "/{$tag->uuid}/updateStatus", $data)->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $parent
     */
    public function testMove($parent)
    {
        $tag = TagData::factory()->create();
        $data = ['parent_uuid' => $parent->uuid];
        $this->patchJson(self::$baseUrl . "/{$tag->uuid}/move", $data)->assertSuccessful();
    }

    public function testGetList()
    {
        $this->getJson(self::$baseUrl)
            ->assertSuccessful()->assertJsonStructure(['data' => ['tags']]);
    }

    public function testGetTagTrees()
    {
        $this->getJson(self::$baseUrl . '/trees')
            ->assertSuccessful()->assertJsonStructure(['data' => ['tagTrees']]);
    }

    public function testGetChildren()
    {
        $tag = TagData::query()->where('level', 1)->first();
        $this->getJson(self::$baseUrl . "/{$tag->uuid}/children")
            ->assertSuccessful()->assertJsonStructure(['data' => ['tags']]);
    }

    /**
     * @depends testStore
     * @param $tag
     */
    public function testTagLogs($tag)
    {
        $this->getJson(self::$baseUrl . "/{$tag->uuid}/logs")
            ->assertSuccessful()->assertJsonStructure(['data' => ['operationLogs']]);
    }

    public function testLogList()
    {
        $this->getJson(self::$baseUrl . "/logs")
            ->assertSuccessful()->assertJsonStructure(['data' => ['operationLogs']]);
    }

    public function testDownload()
    {
        Excel::fake();

        $this->get(self::$baseUrl . '/download')->assertSuccessful();

        Excel::assertDownloaded('标签批量上传模板.xlsx');
    }

    public function testExport()
    {
        Excel::fake();

        $tags = TagData::query()->orderByDesc('number')->limit(3)->get();
        $data = ['uuid' => $tags->pluck('uuid')->toArray()];
        $url = self::$baseUrl . '/export?' . http_build_query($data);
        $this->get($url)->assertSuccessful();

        Excel::matchByRegex();
        Excel::assertDownloaded('/标签批量编辑下载_\d{14}\.xlsx/');
        return $tags;
    }

    /**
     * @depends testExport
     * @param $tags
     */
    public function testTagDelete($tags)
    {
        $this->deleteJson(self::$baseUrl . "/{$tags[0]->uuid}")->assertSuccessful();
        $this->deleteJson(self::$baseUrl . "/{$tags[1]->uuid}")->assertSuccessful();
        $this->deleteJson(self::$baseUrl . "/{$tags[2]->uuid}")->assertSuccessful();
    }
}
