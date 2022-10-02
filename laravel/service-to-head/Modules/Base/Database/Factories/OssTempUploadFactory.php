<?php


namespace Modules\Base\Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Base\Entities\Base\OssTempUpload;

class OssTempUploadFactory extends Factory
{
    protected $model = OssTempUpload::class;

    public function definition()
    {
        return [
            'uuid'        => Str::uuid()->getHex()->toString(),
            'object'      => $this->faker->text(22),
            'bucket'      => 'bucket',
            'origin_body' => []
        ];
    }
}
