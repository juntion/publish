<?php

namespace Modules\Tag\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Base\Tests\AdminTestCase;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Entities\TagDataSource;
use Modules\Tag\Support\Signature;

class TagApiTest extends AdminTestCase
{
    public function testTags()
    {
        $this->getJson('/tag/api/tags', $this->signatureHeaders())
            ->assertSuccessful()->assertJsonStructure(['data' => ['tags']]);
    }

    protected function signatureHeaders()
    {
        $token = config('tag.signature.token');
        $signature = new Signature($token);
        return [
            'Authorization' => 'Oauth ' . $signature->get(),
        ];
    }

    public function testSource()
    {
        $tagDataSources = TagDataSource::factory()->count(3)->create();
        $tags = $tagDataSources->map(function ($item) {
            return $item->tag->number;
        });
        $this->getJson('/tag/api/source?tags=' . implode(',', $tags->toArray()), $this->signatureHeaders())->assertSuccessful();
    }

    public function testSourceTags()
    {
        $tagDataSource = TagDataSource::factory()->create();
        $modelIds = [$tagDataSource->model_id];
        $modelType = $tagDataSource->model_type;
        $url = '/tag/api/source/tags?model_ids=' . implode(',', $modelIds) . "&model_type=" . $modelType;
        $this->getJson($url, $this->signatureHeaders())
            ->assertSuccessful()->assertJsonStructure(['data' => ['source']]);
    }

    public function testSearch()
    {
        $tagDataSource = TagDataSource::factory()->create();
        $name = $tagDataSource->tag->name;
        $this->getJson('/tag/api/source/search?keyword=' . urldecode($name), $this->signatureHeaders())->assertSuccessful();
    }

    public function testUpdateTagBindings()
    {
        $tags = TagData::factory()->count(3)->create();
        $data = [
            'model_id' => Str::uuid()->getHex()->toString(),
            'model_type' => random_int(1, 2),
            'model_desc' => $this->faker->sentence,
            'tags' => implode(',', $tags->pluck('number')->toArray()),
        ];
        $this->patchJson('/tag/api/tags', $data, $this->signatureHeaders())->assertSuccessful();
    }

    public function testBatchUpdateTagBindings()
    {
        for ($i = 0; $i < 2; $i++) {
            $tags = TagData::factory()->count(2)->create();
            $data['related'][] = [
                'model_id' => Str::uuid()->getHex()->toString(),
                'model_type' => random_int(1, 2),
                'model_desc' => $this->faker->sentence,
                'tags' => implode(',', $tags->pluck('number')->toArray()),
            ];
        }
        $this->patchJson('/tag/api/tags/batch', $data, $this->signatureHeaders())->assertSuccessful();
    }
}
