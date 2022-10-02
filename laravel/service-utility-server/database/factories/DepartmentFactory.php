<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'locale' => json_encode(['en' => $faker->name, 'zh-CN' => $faker->name]),
        'is_base' => 1,
    ];
});
