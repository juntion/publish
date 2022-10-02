<?php

namespace Modules\Share\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Admin;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourceCustomCategory;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $admin = Admin::query()->where('name', config('app.root'))->first();
        $uploadCate = ResourceCustomCategory::factory()->create();
        return [
            'uuid'                        => Str::uuid()->getHex()->toString(),
            'creator_uuid'                => $admin->uuid,
            'creator_name'                => $admin->name,
            'custom_category_uuid'        => $uploadCate->uuid,
            'type'                        => $this->faker->randomElement(['picture', 'video']),
            'name'                        => $this->faker->name,
            'object'                      => $this->faker->text(32),
            'object_height_500_width_930' => $this->faker->text(32),
            'object_height_216_width_216' => $this->faker->text(32),
            'size'                        => $this->faker->numberBetween(0, 204800),
            'mime_type'                   => $this->faker->mimeType,
            'format'                      => $this->faker->fileExtension,
            'duration'                    => 0,
            'collection_num'              => 0,
            'download_num'                => 0,
        ];
    }
}

