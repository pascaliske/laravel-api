<?php

use Faker\Generator as Faker;

$factory->define(App\Api\Models\Media::class, function (Faker $faker) {
    return [
        'description' => null,
    ];
});
