<?php

namespace Modules\Share\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Admin;
use Modules\Share\Entities\ResourceTag;

class TagsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResourceTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $admin = Admin::where('name', config('app.root'))->first();
        return [
            'uuid'         => Str::uuid()->getHex()->toString(),
            'name'         => $this->faker->name,
            'creator_uuid' => $admin->uuid
        ];
    }
}

