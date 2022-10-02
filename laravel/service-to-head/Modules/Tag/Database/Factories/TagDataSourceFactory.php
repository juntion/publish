<?php

namespace Modules\Tag\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Entities\TagDataSource;

class TagDataSourceFactory extends Factory
{
    protected $model = TagDataSource::class;

    public function definition()
    {
        $tag = TagData::factory()->create();
        return [
            'tag_data_uuid' => $tag->uuid,
            'model_type' => random_int(1, 2),
            'model_id' => Str::uuid()->getHex()->toString(),
            'model_desc' => $this->faker->sentence,
            'priority' => random_int(0, 100),
        ];
    }
}
