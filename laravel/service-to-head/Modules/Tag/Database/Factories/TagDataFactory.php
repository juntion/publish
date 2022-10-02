<?php

namespace Modules\Tag\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tag\Entities\TagData;

class TagDataFactory extends Factory
{
    protected $model = TagData::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'status' => random_int(1, 2),
            'locale' => [
                'en' => $this->faker->name,
                'cn' => $this->faker->name,
            ],
            'type' => 1,
            'url_name' => $this->faker->sentence,
        ];
    }
}
