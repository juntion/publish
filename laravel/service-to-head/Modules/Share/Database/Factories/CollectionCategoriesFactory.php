<?php

namespace Modules\Share\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Admin;
use Modules\Share\Entities\CollectionCategory;

class CollectionCategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CollectionCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $admin = Admin::where('name', config('app.root'))->first();
        $uuid = Str::uuid()->getHex()->toString();
        return [
            'uuid'           => $uuid,
            'admin_uuid'     => $admin->uuid,
            'type'           => $this->faker->randomElement(['picture', 'video']),
            'one_level_uuid' => $uuid,
            'name'           => $this->faker->name,
            'sort'           => $this->faker->numberBetween(0, 255),
            'sum'            => 0
        ];
    }
}

