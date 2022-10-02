<?php

namespace Modules\Tag\Tests\Feature;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Base\Tests\AdminTestCase;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Entities\TagDataSource;

class TagBindingTest extends AdminTestCase
{
    private static $baseUrl = '/tag/binding';

    public function testStore()
    {
        $this->postJson(self::$baseUrl, $this->generateBindingData())
            ->assertSuccessful();
    }

    private function generateBindingData()
    {
        $tags = TagData::factory()->count(5)->create();
        return [
            'tag_uuid' => $this->faker()->randomElement($tags)->uuid,
            'binding_type' => random_int(1, 2),
            'model_id' => Str::uuid()->getHex()->toString(),
            'model_desc' => $this->faker()->sentence,
            'priority' => random_int(0, 100),
        ];
    }

    public function testUpdate()
    {
        $tags = TagData::factory()->count(5)->create();
        $data = [
            'tag_uuid' => $this->faker()->randomElement($tags)->uuid,
            'priority' => random_int(0, 100),
        ];
        $tagDataSource = TagDataSource::query()->latest()->limit(1)->first();
        $this->patchJson(self::$baseUrl . "/{$tagDataSource->uuid}", $data)->assertSuccessful();
    }

    public function testBindingList()
    {
        $this->getJson(self::$baseUrl)->assertSuccessful()->assertJsonStructure(['data' => ['tagDataSources']]);
    }

    public function testDownload()
    {
        Excel::fake();

        $this->get(self::$baseUrl . '/download')->assertSuccessful();

        Excel::matchByRegex();
        Excel::assertDownloaded("/.+批量上传模板下载\.xlsx/");
    }

    public function testExport()
    {
        Excel::fake();

        $tagDataSource = TagDataSource::factory()->count(3)->create();
        $data = [
            'binding_type' => random_int(1, 2),
            'uuid' => $tagDataSource->pluck('uuid')->toArray(),
        ];
        $url = self::$baseUrl . '/export?' . http_build_query($data);
        $this->get($url)->assertSuccessful();

        Excel::matchByRegex();
        Excel::assertDownloaded('/绑定批量编辑下载\d{14}\.xlsx/');
    }

    public function testBindingTags()
    {
        $tagDataSource = TagDataSource::factory()->create();
        $data = [
            'binding_type' => $tagDataSource->model_type,
            'model_id' => $tagDataSource->model_id,
        ];
        $url = self::$baseUrl . '/tags?' . http_build_query($data);
        $this->getJson($url)->assertSuccessful()->assertJsonStructure(['data' => ['tags']]);
    }

    public function testDelete()
    {
        $tagDataSource = TagDataSource::factory()->create();
        $this->deleteJson(self::$baseUrl . "/{$tagDataSource->uuid}")->assertSuccessful();
    }

    /**
     * @depends testStore
     */
    public function testBatchUnbind()
    {
        $tagDataSource = TagDataSource::factory()->count(2)->create();
        $data = ['binding_uuids' => $tagDataSource->pluck('uuid')->toArray()];
        $this->postJson(self::$baseUrl . '/batchUnbind', $data)->assertSuccessful();
    }
}
