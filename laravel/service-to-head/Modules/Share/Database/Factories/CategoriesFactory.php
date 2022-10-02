<?php

namespace Modules\Share\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Share\Entities\ResourceCategory;

class CategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResourceCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $uuid = Str::uuid()->getHex()->toString();
        return [
            'uuid'           => $uuid,
            'background'     => 'cover-'.rand(1, 30),
            'type'           => $this->faker->randomElement(['picture', 'video']),
            'one_level_uuid' => $uuid,
            'name'           => $this->faker->name,
            'sort'           => $this->faker->numberBetween(0, 255),
            'sum'            => 0
        ];
    }
}

